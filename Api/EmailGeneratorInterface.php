<?php

namespace Perspective\OptionalEmail\Api;

use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Model\Customer;

interface EmailGeneratorInterface
{

    public const AT_DOMAIN = 'generated.io';

    /**
     * @param null|CustomerInterface|Customer $customer
     *
     * @return null|string
     */
    public function generate($customer = null);
}
