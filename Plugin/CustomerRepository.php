<?php

namespace Perspective\OptionalEmail\Plugin;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Perspective\OptionalEmail\Api\EmailGeneratorInterface;
use Perspective\OptionalEmail\Model\CustomerEx;

class CustomerRepository
{

    /**
     * @var EmailGeneratorInterface
     */
    private $emailGenerator;

    public function __construct(EmailGeneratorInterface $emailGenerator)
    {
        $this->emailGenerator = $emailGenerator;
    }

    /**
     * @param CustomerRepositoryInterface $subject
     * @param CustomerInterface $customer
     *
     * @return array
     */
    public function beforeSave(CustomerRepositoryInterface $subject, CustomerInterface $customer)
    {
        $email = $customer->getEmail();

        if (!is_string($email) || mb_strlen($email) < 1) {
            $email = $this->emailGenerator->generate($customer);
            $customer->setData(CustomerInterface::EMAIL, $email);
        }

        return [$customer];
    }
}
