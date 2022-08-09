<?php

namespace Perspective\OptionalEmail\Plugin;

use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Quote\Api\Data\CartInterface;
use Magento\Quote\Model\QuoteRepository;
use Perspective\OptionalEmail\Model\EmailResolver;

class CartRepository
{

    /**
     * @var EmailResolver
     */
    private $emailResolver;

    /**
     * @param EmailResolver $emailResolver
     */
    public function __construct(EmailResolver $emailResolver)
    {
        $this->emailResolver = $emailResolver;
    }

    public function beforeSave(
        CartRepositoryInterface $subject,
        CartInterface   $quote
    ) {
        $customer = $quote->getCustomer();
        $email = $quote->getCustomerEmail();

        if ($customer && $email && $this->emailResolver->isGeneratedEmail($email)) {
            $quote->setCustomerEmail($this->emailResolver->resolveFor($customer, $email));
        }

        return [$quote];
    }
}
