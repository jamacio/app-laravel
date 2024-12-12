<?php

namespace App\Menu\Filters;

use App\Helpers\MenuItemHelper;
use App\Menu\ActiveChecker;

class ActiveFilter implements FilterInterface
{
    /**
     * The active checker instance.
     *
     * @var ActiveChecker
     */
    protected $activeChecker;

    /**
     * Constructor.
     *
     * @param  ActiveChecker  $activeChecker
     */
    public function __construct(ActiveChecker $activeChecker)
    {
        $this->activeChecker = $activeChecker;
    }

    /**
     * Transforms a menu item. Check if an item is active based on the current
     * requested URL and compile it's active property.
     *
     * @param  array  $item  A menu item
     * @return array
     */
    public function transform($item)
    {
        if (! MenuItemHelper::isHeader($item)) {
            $item['active'] = $this->activeChecker->isActive($item);
        }

        return $item;
    }
}
