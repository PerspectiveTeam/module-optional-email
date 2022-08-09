<?php
/**
 * Copyright © Perspective Studio All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Perspective\OptionalEmail\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface RuleSearchResultsInterface extends SearchResultsInterface
{

    /**
     * Get rule list.
     * @return RuleInterface[]
     */
    public function getItems();

    /**
     * Set where_area list.
     *
     * @param RuleInterface[] $items
     *
     * @return $this
     */
    public function setItems(array $items);
}
