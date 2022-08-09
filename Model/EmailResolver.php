<?php

namespace Perspective\OptionalEmail\Model;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\State;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Filesystem\DirectoryList;
use Magento\Framework\Math\Random;
use Magento\Framework\Serialize\Serializer\Json;
use Perspective\OptionalEmail\Api\Data\RuleInterface;
use Perspective\OptionalEmail\Api\EmailGeneratorInterface;
use Perspective\OptionalEmail\Api\EmailResolverInterface;
use Perspective\OptionalEmail\Api\RuleRepositoryInterface;

class EmailResolver implements EmailResolverInterface
{

    /**
     * @var Session
     */
    private $customerSession;

    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepository;

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var State
     */
    private $state;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var FilterBuilder
     */
    private $filterBuilder;

    /**
     * @var RuleRepositoryInterface
     */
    private $ruleRepository;

    /**
     * @var XmlBacktrace
     */
    private $xmlBacktrace;

    /**
     * @var Random
     */
    private $random;

    public function __construct(
        Session                     $customerSession,
        CustomerRepositoryInterface $customerRepository,
        ScopeConfigInterface        $scopeConfig,
        State                       $state,
        SearchCriteriaBuilder       $searchCriteriaBuilder,
        FilterBuilder               $filterBuilder,
        XmlBacktrace                $xmlBacktrace,
        RuleRepositoryInterface     $ruleRepository,
        Random                      $random,
        Json                      $json,
        DirectoryList             $directoryList
    ) {
        $this->customerSession = $customerSession;
        $this->customerRepository = $customerRepository;
        $this->scopeConfig = $scopeConfig;
        $this->state = $state;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterBuilder = $filterBuilder;
        $this->xmlBacktrace = $xmlBacktrace;
        $this->ruleRepository = $ruleRepository;
        $this->random = $random;
        $this->json = $json;

        $this->logFile = $directoryList->getPath('log') . "/poe.log";
    }

    public function isGeneratedEmail(?string $email)
    {
        $suffix = '@' . EmailGeneratorInterface::AT_DOMAIN;
        return $email !== null && substr($email, -1 * strlen($suffix)) === $suffix;
    }

    private function log(string $message, array $context = [])
    {
        $context = $this->json->serialize($context);

        file_put_contents(
            $this->logFile,
            "$message $context\n",
            FILE_APPEND
        );
    }

    /**
     * @inheritDoc
     */
    public function resolveFor($customer = null, $coreEmail = false)
    {
        if (is_numeric($customer) || is_string($customer)) {
            $customer = $this->customerRepository->getById((int)$customer);
        }

        if ($customer === null) {
            $customer = $this->customerSession->getCustomer();
        }

        if ($coreEmail === false) {
            $coreEmail = $customer->getEmail();
        }

        if (!$this->isGeneratedEmail($coreEmail)) {
            return $coreEmail;
        }

        $debugMode = $this->scopeConfig->getValue("perspective_optionalemail/debug/enabled") ?? false;
        $debugPrefix = $this->scopeConfig->getValue("perspective_optionalemail/debug/prefix") ?? false;

        try {
            $currentArea = $this->state->getAreaCode();
        } catch (LocalizedException $e) {
            $currentArea = null;
        }

        $this->searchCriteriaBuilder->addFilters([
            $this->filterBuilder->setField(RuleInterface::AREA)
                                ->setValue(null)
                                ->setConditionType('null')
                                ->create(),
            $this->filterBuilder->setField(RuleInterface::AREA)
                                ->setValue($currentArea)
                                ->setConditionType('eq')
                                ->create(),
        ]);

        $this->searchCriteriaBuilder->addSortOrder(new SortOrder([
            SortOrder::FIELD => RuleInterface::AREA,
            SortOrder::DIRECTION => SortOrder::SORT_DESC,
        ]));

        $nullHandlingRules = $this->ruleRepository->getList($this->searchCriteriaBuilder->create());

        if ($debugMode && $debugPrefix) {
            $emailPrefix = $this->random->getRandomString(6);
            $emailPrefix = "debug-$emailPrefix-";
            $coreEmail = $emailPrefix . $coreEmail;
        }

        if ($nullHandlingRules->getTotalCount() === 0) {
            if ($debugMode) {
                $this->log("optional email (= $coreEmail) resolved: 0 rules found", [
                    'area' => $currentArea,
                ]);
            }

            return $coreEmail;
        }

        $backtrace = $this->xmlBacktrace->create();
        foreach ($nullHandlingRules->getItems() as $nullHandlingRule) {
            $backtraceMatched = $this->xmlBacktrace->evaluateXpath($backtrace, $nullHandlingRule->getBacktraceXpath());
            if ($backtraceMatched) {
                $matchedRule = $nullHandlingRule;
                break;
            }
        }

        if (!isset($matchedRule) || !$matchedRule) {
            if ($debugMode) {
                $this->log("optional email (= $coreEmail) resolved: no rule matching backtrace", [
                    'area' => $currentArea,
                    'backtrace' => $backtrace,
                ]);
            }

            return $coreEmail;
        }

        if ($matchedRule->getPassNulls()) {
            $coreEmail = null;
        }

        if ($debugMode) {
            if ($matchedRule->getPassNulls()) {
                $this->log("optional email (= null) resolved: first rule allow nulls", [
                    'area' => $currentArea,
                    'backtrace' => $backtrace,
                    'rule' => $matchedRule->getData(),
                ]);
            } else {
                $this->log("optional email (= $coreEmail) resolved: first rule doesn't allow nulls", [
                    'area' => $currentArea,
                    'backtrace' => $backtrace,
                    'rule' => $matchedRule->getData(),
                ]);
            }
        }

        return $coreEmail;
    }
}
