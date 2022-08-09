<?php

namespace Perspective\OptionalEmail\Model;

use Magento\Framework\Math\Random;
use Perspective\OptionalEmail\Api\EmailGeneratorInterface;

class EmailGenerator implements EmailGeneratorInterface
{

    /**
     * @var Random
     */
    private $random;

    public function __construct(Random $random)
    {
        $this->random = $random;
    }

    /**
     * @inheritDoc
     */
    public function generate($customer = null)
    {
        // todo: resolve current customer

        return "{$this->random->getRandomString(10, 'abcdefghijklmnopqrstuvwxyz')}@" . EmailGeneratorInterface::AT_DOMAIN;
    }
}
