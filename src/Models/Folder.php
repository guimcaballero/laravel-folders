<?php

namespace Guimcaballero\LaravelFolders\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use InvalidArgumentException;

/**
 * @property string $name
 */
class Folder extends Model
{
    public $guarded = [];

    /**
     * Get the owning folderable model.
     */
    public function folderable()
    {
        return $this->morphTo();
    }

    /**
     * Creates a new folder with given name
     *
     * @param string $name
     * @return Folder
     */
    public static function createNewFolder(string $name): Folder
    {
        if (
            strpos($name, ' ') !== false
            || strpos($name, '\\') !== false
            || strpos($name, '/') !== false
        ) {
            throw new InvalidArgumentException($name . ' is not a valid input.');
        }

        $folder = new Folder([
            'name' => $name,
        ]);
        $folder->save();

        Storage::disk('public')->makeDirectory(config('laravel-folders.directory_name') . '/' . $folder->name);

        return $folder;
    }

    /**
     * Creates a new folder with a random name
     *
     * @return Folder
     */
    public static function createNewRandomFolder(): Folder
    {
        $name = '';
        $counter = 0;
        do {
            $name = Str::random(20 + $counter++);
        } while (Folder::where("name", $name)->first() != null);

        return Folder::createNewFolder($name);
    }

    public function setNameAttribute($value)
    {
        if (isset($this->attributes['name'])) {
            throw new Exception('A folder\'s name is not editable');
        } else {
            $this->attributes['name'] = $value;
        }
    }

    public function getListOfFiles(): array
    {
        return Storage::disk('public')->files(config('laravel-folders.directory_name') . '/' . $this->name);
    }









    public function uploadFiles($files)
    {
        foreach ($files as $key => $file) {
            $this->uploadSingleFile($file);
        }
    }

    public function uploadSingleFile($file)
    {
        Storage::disk('public')->putFileAs(config('laravel-folders.directory_name') . '/' . $this->name, $file, $file->getClientOriginalName());
    }

    public function removeFiles($files)
    {
        foreach ($files as $key => $file) {
            $this->removeSingleFile($file);
        }
    }

    public function removeSingleFile($file)
    {
        $exists = Storage::disk('public')->exists(config('laravel-folders.directory_name') . '/' . $this->name . '/' . $file);
        if ($exists) {
            Storage::disk('public')->delete(config('laravel-folders.directory_name') . '/' . $this->name . '/' . $file);
        }
    }
}
