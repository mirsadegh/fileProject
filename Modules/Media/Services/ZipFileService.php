<?php


namespace Modules\Media\Services;


use Illuminate\Http\UploadedFile;
use Modules\Media\Entities\Media;
use Illuminate\Support\Facades\Storage;

use Modules\Media\Services\DefaultFileService;
use Modules\Media\Contracts\FileServiceContract;

class ZipFileService extends DefaultFileService implements FileServiceContract
{

    public static function upload(UploadedFile $file, $filename, $dir):array
    {
        Storage::putFileAs($dir , $file , $filename . '.' . $file->getClientOriginalExtension());
        return ["zip" =>   $filename . '.' . $file->getClientOriginalExtension()] ;
    }


    public static function thumb(Media $media)
    {
        return url('/img/zip-thumb.jpg');
    }

    public static function getFilename()
    {
        return (static::$media->is_private ? 'private/':'public/') . static::$media->files['zip'];
    }

    public static function delete(Media $media)
    {
        // TODO: Implement delete() method.
    }

    public static function stream(Media $media)
    {
        // TODO: Implement stream() method.
    }
}
