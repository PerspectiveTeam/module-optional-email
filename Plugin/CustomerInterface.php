<?php

namespace Perspective\OptionalEmail\Plugin;

use Perspective\OptionalEmail\Api\EmailResolverInterface;

class CustomerInterface
{

    /**
     * @var EmailResolverInterface
     */
    private $emailResolver;

    public function __construct(EmailResolverInterface $emailResolver)
    {
        $this->emailResolver = $emailResolver;
    }

    /**
     * @param \Magento\Customer\Api\Data\CustomerInterface $subject
     * @param $coreEmail
     *
     * @return string
     */
    public function afterGetEmail(\Magento\Customer\Api\Data\CustomerInterface $subject, $coreEmail)
    {
        return $this->emailResolver->resolveFor($subject, $coreEmail);
    }
}
