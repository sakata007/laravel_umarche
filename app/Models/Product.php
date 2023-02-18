<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SecondaryCategory;
use App\Models\Image;
use App\Models\User;
use App\Models\Stock;
use PhpParser\Builder\Function_;
use PhpParser\Node\Expr\FuncCall;


class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'infomation',
        'price',
        'is_selling',
        'shop_id',
        'sort_order',
        'secondary_category_id',
        'image1',
        'image2',
        'image3',
        'image4',
    ];

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
    // ↓データベースカラム名と一致するとエラーが発生するため変更している
    public function imageFirst()
    {
        return $this->belongsTo(Image::class, 'image1', 'id');
    }
    public function imageSecond()
    {
        return $this->belongsTo(Image::class, 'image2', 'id');
    }
    public function imageThird()
    {
        return $this->belongsTo(Image::class, 'image3', 'id');
    }
    public function imageForth()
    {
        return $this->belongsTo(Image::class, 'image4', 'id');
    }

    public function stock()
    {
        return $this->hasMany(Stock::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'carts')
        ->withPivot(['id', 'quantity']);
    }
}
