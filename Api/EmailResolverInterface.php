<?php

namespace Perspective\OptionalEmail\Api;

use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Model\Customer;

interface EmailResolverInterface
{

    /**
     * @param null|int|CustomerInterface|Customer $customer
     * @param null|false|string $coreEmail
     *
     * @return null|string
     */
    public function resolveFor($customer = null, ?string $coreEmail = null);
}
