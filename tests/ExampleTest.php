<?php

namespace Guimcaballero\LaravelFolders\Tests;

use Orchestra\Testbench\TestCase;
use Guimcaballero\LaravelFolders\LaravelFoldersServiceProvider;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [LaravelFoldersServiceProvider::class];
    }
    
    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
