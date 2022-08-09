<?php
/**
 * Copyright © Perspective Studio All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Perspective\OptionalEmail\Model\ResourceModel\Rule;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Perspective\OptionalEmail\Api\Data\RuleInterface;
use Perspective\OptionalEmail\Model\ResourceModel\Rule;

class Collection extends AbstractCollection
{

    /**
     * @inheritDoc
     */
    protected $_idFieldName = RuleInterface::RULE_ID;

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(\Perspective\OptionalEmail\Model\Rule::class, Rule::class);
    }
}

