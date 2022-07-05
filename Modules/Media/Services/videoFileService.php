<?php


namespace Modules\Media\Services;


use Modules\Media\Entities\Media;
use Illuminate\Support\Facades\Storage;
use Modules\Media\Contracts\FileServiceContract;


class videoFileService extends DefaultFileService implements FileServiceContract
{

    public static function upload($file,$filename,$dir) :array
    {

        $extension = $file->getClientOriginalExtension();
        $dir = 'private\\';
        Storage::putFileAs($dir , $file , $filename . '.' . $extension);

       return ["video" =>   $filename . '.' . $extension] ;

    }

    public static function thumb(Media $media)
    {
        return url('/img/video-thumb.png');
    }
    public static function getFilename()
    {
        return (static::$media->is_private ? 'private/':'public/') . static::$media->files['video'];
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
