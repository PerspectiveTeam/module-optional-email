<?php

namespace Perspective\OptionalEmail\Plugin;

use Magento\Sales\Model\Order\Address\Validator;

class OrderAddressValidator
{

    public function afterValidate(
        Validator $subject,
        array     $warnings
    ) {
        return array_filter($warnings, function ($warning) {
            return $warning !== 'Email has a wrong format';
        });
    }
}
