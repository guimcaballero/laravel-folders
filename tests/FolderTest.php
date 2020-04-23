<?php

namespace Guimcaballero\LaravelFolders\Tests;

use CreateFoldersTable;
use Exception;
use Guimcaballero\LaravelFolders\Models\Folder;
use Orchestra\Testbench\TestCase;
use Guimcaballero\LaravelFolders\LaravelFoldersServiceProvider;
use InvalidArgumentException;

class FolderTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [LaravelFoldersServiceProvider::class];
    }

    public function setUp() : void
    {
        parent::setUp();

        require_once __DIR__ . '/../database/migrations/2020_04_20_141823_create_folders_table.php';

        (new CreateFoldersTable())->up();
    }

    public function testCanCreateFolder()
    {
        $this->assertCount(0, Folder::all());

        Folder::createNewFolder('someFolderName');

        $this->assertCount(1, Folder::all());
    }

    public function testCanCreateRandomFolder()
    {
        $this->assertCount(0, Folder::all());

        Folder::createNewRandomFolder();

        $this->assertCount(1, Folder::all());
    }

    public function testCantCreateFolderWithRepeatedName()
    {
        Folder::createNewFolder('someFolderName');


        $this->expectException(\Illuminate\Database\QueryException::class);

        Folder::createNewFolder('someFolderName');

        $this->assertCount(1, Folder::all());
    }

    public function testCantCreateFolderWithSpacesInName()
    {
        $this->expectException(InvalidArgumentException::class);

        Folder::createNewFolder('invalid name');
        $this->assertCount(0, Folder::all());
    }

    public function testCantChangeFolderName()
    {
        $folder = Folder::createNewFolder('name');

        $this->expectException(Exception::class);
        $folder->name = 'other';
    }
}
