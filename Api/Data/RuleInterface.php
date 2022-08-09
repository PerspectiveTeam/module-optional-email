<?php
/**
 * Copyright © Perspective Studio All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Perspective\OptionalEmail\Api\Data;

interface RuleInterface
{

    const RULE_ID = 'rule_id';

    const AREA = 'area';

    const BACKRACE_XPATH = 'backtrace_xpath';

    const PASS_NULLS = 'pass_nulls';

    const COMMENT = 'comment';

    /**
     * Get rule_id
     * @return null|int
     */
    public function getRuleId();

    /**
     * Set rule_id
     *
     * @param int $ruleId
     *
     * @return $this
     */
    public function setRuleId(int $ruleId);

    /**
     * Get area
     * @return string|null
     */
    public function getArea();

    /**
     * Set where_area
     *
     * @param null|string $area
     *
     * @return $this
     */
    public function setArea(?string $area);

    /**
     * Get backrace_xpath
     * @return null|string
     */
    public function getBacktraceXpath();

    /**
     * Set backrace_xpath
     *
     * @param null|string $backtraceXpath
     *
     * @return $this
     */
    public function setBacktraceXpath(?string $backtraceXpath);

    /**
     * Get pass_nulls
     * @return null|bool
     */
    public function getPassNulls();

    /**
     * Set pass_nulls
     *
     * @param bool $pass_nulls
     *
     * @return $this
     */
    public function setPassNulls(bool $pass_nulls);

    /**
     * Get comment
     * @return null|bool
     */
    public function getComment();

    /**
     * Set comment
     *
     * @param null|string $comment
     *
     * @return $this
     */
    public function setComment(?string $comment);
}
