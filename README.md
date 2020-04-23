# Description

[![Latest Version on Packagist](https://img.shields.io/packagist/v/guimcaballero/laravel-folders.svg?style=flat-square)](https://packagist.org/packages/guimcaballero/laravel-folders)
[![Build Status](https://img.shields.io/travis/guimcaballero/laravel-folders/master.svg?style=flat-square)](https://travis-ci.org/guimcaballero/laravel-folders)
[![Quality Score](https://img.shields.io/scrutinizer/g/guimcaballero/laravel-folders.svg?style=flat-square)](https://scrutinizer-ci.com/g/guimcaballero/laravel-folders)
[![Total Downloads](https://img.shields.io/packagist/dt/guimcaballero/laravel-folders.svg?style=flat-square)](https://packagist.org/packages/guimcaballero/laravel-folders)

This is a very simple package that implements Folders, where you can save as many files as you want to a model, while only having one column.

Folders behave just like a normal folder on you OS would, you can add, remove and list files. Adding files doesn't remove existing files.

## Installation

You can install the package via composer:

```bash
composer require guimcaballero/laravel-folders
```

Then run the migrations:

```bash
php artisan migrate
```

# Configuration

You can publish the migrations with:

```bash
php artisan vendor:publish --provider="Guimcaballero\LaravelFolders\LaravelFoldersServiceProvider"
```

## Example

This is a simple use case where we want to be able to upload a list of important files in a User:

In App\User:

```php
<?php

namespace App;

...
use Guimcaballero\LaravelFolders;

class User extends Authenticatable
{
    ...

    public function importantDocuments()
    {
        return $this->morphOne(Folder::class, 'folderable');
    }
}
```

Then in web.php:

```php
    Route::post('user/uploadImportantFiles', function(Request $request) {
        $folder = auth()->user()->importantDocuments;
        $folder->uploadFiles($request->file('files'));

        dd($folder->getListOfFiles());
    });
```

# Usage

## List all files in a folder

```php
    $folder->getListOfFiles();
```

This will return an array with the files inside the folder.

## Uploading multiple files

You can upload multiple files at once with:

```php
    $folder->uploadFiles($request->file('files'));
```

## Uploading a single file

You can upload a single file with:

```php
    $folder->uploadSingleFile($request->file('file'));
```

## Removing files

To remove multiple files, pass an array containing the names of the files:

```php
    $folder->removeFiles(['importantFile1.pdf', 'importantFile2.pdf']);
```

## Removing a single file

To remove a single file, pass the name of the file:

```php
    $folder->removeSingleFile('importantFile1.pdf');
```

## Multiple folders

You can have more than one folder in a class, like for example:

```php
    public function importantDocuments()
    {
        return $this->morphOne(Folder::class, 'folderable');
    }

    public function lessImportantDocuments()
    {
        return $this->morphOne(Folder::class, 'folderable');
    }
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Feel free to Contribute to this project!

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

-   [Guim Caballero](https://github.com/guimcaballero)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
