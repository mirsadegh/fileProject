<?php


namespace Modules\Media\Services;


use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Modules\Media\Contracts\FileServiceContract;
use Modules\Media\Entities\Media;


class ImageFileService extends DefaultFileService implements FileServiceContract
{
    protected static $sizes = ['300','600'];

    public static function upload(UploadedFile $file,string $filename,$dir) :array
    {
        Storage::putFileAs($dir , $file , $filename . '.' . $file->getClientOriginalExtension());
//        $file->move(storage_path($dir),$filename . '.' . $extension);
        $path = $dir. $filename . '.' . $file->getClientOriginalExtension();

        return self::resize(Storage::path($path) , $dir , $filename , $file->getClientOriginalExtension());


    }

    private static function resize($img , $dir , $filename , $extension)
    {
        $img = Image::make($img);
        $imgs['original'] =   $filename. '.' . $extension;
        foreach (self::$sizes as $size){
            $imgs[$size] =  $filename . '_'. $size. '.'. $extension;
            $img->resize($size,null,function ($aspect){
                $aspect->aspectRatio();
            })
                ->save(Storage::path($dir). $filename . '_'. $size. '.'. $extension);
        }

        return $imgs;

    }

    public static function getFilename()
    {
        return (static::$media->is_private ? 'private/':'public/') . static::$media->files['original'];
    }


    public static function thumb(Media $media)
    {
        if($media)
       return "/storage/". $media->files['300'];

       return '/panel/img/profile.jpg';
    }

    public static function delete($media)
    {
        foreach ($media->files as $file) {
            Storage::delete('public\\'.$file);
        }
    }

    public static function stream(Media $media)
    {
        // TODO: Implement stream() method.
    }
}
