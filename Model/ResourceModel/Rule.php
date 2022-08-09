<?php
/**
 * Copyright © Perspective Studio All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Perspective\OptionalEmail\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Perspective\OptionalEmail\Api\Data\RuleInterface;

class Rule extends AbstractDb
{

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init('perspective_optionalemail_rule', RuleInterface::RULE_ID);
    }
}
