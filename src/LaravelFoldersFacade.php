<?php

namespace Guimcaballero\LaravelFolders;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Guimcaballero\LaravelFolders\Skeleton\SkeletonClass
 */
class LaravelFoldersFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-folders';
    }
}
