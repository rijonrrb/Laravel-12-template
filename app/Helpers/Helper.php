<?php

use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;


if (!function_exists('getSetting')) {
    /**
     * @return mixed
     */
    function getSetting(): Setting
    {
        return Setting::orderBy('id', 'DESC')->first();
    }
}

if (!function_exists('getPhoto')) {
    function getPhoto($path): string
    {
        if ($path) {
            $ppath = public_path($path);
            if (file_exists($ppath)) {
                return asset($path);
            } else {
                return asset('frontend/assets/images/no_image.jpg');
            }
        } else {
            return asset('frontend/assets/images/no_image.jpg');
        }
    }
}

if (!function_exists('getAvatar')) {
    function getAvatar($path)
    {
        if (!empty($path)) {
            return $path;
        } else {
            // return asset('assets/img/card/personal.png');
            return asset('assets/image/default-profile.png');
        }
    }
}

if (!function_exists('makeUrl')) {
    function makeUrl($url)
    {
        if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
            $url = "https://" . $url;
        }
        return $url;
    }
}

function formatFileName($file): string
{
    $base_name = preg_replace('/\..+$/', '', $file->getClientOriginalName());
    $base_name = explode(' ', $base_name);
    $base_name = implode('-', $base_name);
    $base_name = Str::lower($base_name);
    return $base_name . "-" . uniqid() . "." . $file->getClientOriginalExtension();
}

function uploadGeneralImage(?object $file, string $path, $oldImage = null): string
{
    $pathCreate = public_path("/uploads/$path/");
    if (!File::isDirectory($pathCreate)) {
        File::makeDirectory($pathCreate, 0777, true, true);
    }
    if ($oldImage && File::exists(public_path($oldImage))) {
        File::delete(public_path($oldImage));
    }

    $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
    $file->move(public_path('/uploads/' . $path . '/'), $fileName);
    return "uploads/$path/" . $fileName;
}

function lazyLoadImageAttr($src){
    return 'data-src="'.$src.'" src="'.lazyLoadImage().'"';
}

function lazyLoadImage(){
    return asset('assets/images/lazyload.webp');
}
