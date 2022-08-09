<?php
/**
 * Copyright © Perspective Studio All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Perspective\OptionalEmail\Model;

use Magento\Framework\Model\AbstractModel;
use Perspective\OptionalEmail\Api\Data\RuleInterface;

class Rule extends AbstractModel implements RuleInterface
{

    protected $_idFieldName = 'rule_id';

    /**
     * @inheritDoc
     */
    public function _construct()
    {
        $this->_init(ResourceModel\Rule::class);
    }

    /**
     * @inheritDoc
     */
    public function getRuleId()
    {
        return (int)$this->getData(self::RULE_ID);
    }

    /**
     * @inheritDoc
     */
    public function setRuleId(int $ruleId)
    {
        return $this->setData(self::RULE_ID, $ruleId);
    }

    /**
     * @inheritDoc
     */
    public function getArea()
    {
        return $this->getData(self::AREA);
    }

    /**
     * @inheritDoc
     */
    public function setArea(?string $area)
    {
        return $this->setData(self::AREA, $area);
    }

    /**
     * @inheritDoc
     */
    public function getBacktraceXpath()
    {
        return $this->getData(self::BACKRACE_XPATH);
    }

    /**
     * @inheritDoc
     */
    public function setBacktraceXpath(?string $backtraceXpath)
    {
        return $this->setData(self::BACKRACE_XPATH, $backtraceXpath);
    }

    /**
     * @inheritDoc
     */
    public function getPassNulls()
    {
        return (bool)$this->getData(self::PASS_NULLS);
    }

    /**
     * @inheritDoc
     */
    public function setPassNulls(bool $pass_nulls)
    {
        return $this->setData(self::PASS_NULLS, (int)$pass_nulls);
    }

    /**
     * @inheritDoc
     */
    public function getComment()
    {
        return (bool)$this->getData(self::COMMENT);
    }

    /**
     * @inheritDoc
     */
    public function setComment(?string $comment)
    {
        return $this->setData(self::COMMENT, $comment);
    }
}

