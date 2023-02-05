<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use InterventionImage;

class ImageService
{
    public static function upload($imageFile, $folderName)
    {
        $fileName = uniqid(rand(). '_');
        $extension = $imageFile->extension();
        $fileNameToStore = $fileName . '.' . $extension;
        $resizedImage = InterventionImage::make($imageFile)->resize(1920, 1080)->encode(); //サイズを指定
        Storage::put('public/' . $folderName . '/' . $fileNameToStore, $resizedImage);

        return $fileNameToStore;

        // $fileName = uniqid(rand(). '_'); //ランダムなファイル名を作成
        // $extension = $imageFile->extension(); //拡張子を取得
        // $fileNameToStore = $fileName . '.' . $extension; //作ったファイル名と拡張子を結合
        // $resizedImage = InterventionImage::make($imageFile)->resize(1920, 1080)->encode(); //サイズを指定

        // // dd($imageFile, $resizedImage);

        // Storage::put('public/shops/' . $fileNameToStore, $resizedImage);


    }
}
