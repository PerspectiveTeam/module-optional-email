<?php
/**
 * Copyright © Perspective Studio All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Perspective\OptionalEmail\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface RuleRepositoryInterface
{

    /**
     * Save rule
     * @param \Perspective\OptionalEmail\Api\Data\RuleInterface $rule
     * @return \Perspective\OptionalEmail\Api\Data\RuleInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Perspective\OptionalEmail\Api\Data\RuleInterface $rule
    );

    /**
     * Retrieve rule
     * @param string $ruleId
     * @return \Perspective\OptionalEmail\Api\Data\RuleInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($ruleId);

    /**
     * Retrieve rule matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Perspective\OptionalEmail\Api\Data\RuleSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete rule
     * @param \Perspective\OptionalEmail\Api\Data\RuleInterface $rule
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Perspective\OptionalEmail\Api\Data\RuleInterface $rule
    );

    /**
     * Delete rule by ID
     * @param string $ruleId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($ruleId);
}

