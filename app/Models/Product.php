<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SecondaryCategory;
use App\Models\Image;

class Product extends Model
{
    use HasFactory;

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
    public function category()
    {
        // 関数名とモデル名が一致しない
        // →第二引数で、テーブルのカラムを指定する必要がある
        return $this->belongsTo(SecondaryCategory::class, 'secondary_category_id');
    }
    public function imageFirst()
    // ↑データベースカラム名と一致するとエラーが発生するため変更している
    {
        return $this->belongsTo(Image::class, 'image1', 'id');
    }
}
