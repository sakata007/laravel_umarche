<?php

namespace App\Services;
use App\Models\Cart;
use App\Models\Product;

class CartService
{
    public static function getItemsInCart($items)
    {
        $products = [];

        // dd($items);
        foreach($items as $item){
            $p = Product::findOrFail($item->product_id);//一つの商品を取得
            $owner = $p->shop->owner->select('name', 'email')->first()->toArray();//オーナー情報
            // dd($owner);
            // array:2 [▼
            // "name" => "test"
            // "email" => "test1@test.com"
            // ]
            $values = array_values($owner);//連想配列の値を取得
            // dd($values);
            // array:2 [▼
            // 0 => "test"
            // 1 => "test1@test.com"
            // ]
            $keys = ['ownerName', 'email'];
            $ownerInfo = array_combine($keys, $values);//オーナー情報のキーを変更
            // dd($ownerInfo);
            // この時のddの値↓
            // array:2 [▼
            // "ownerName" => "test"
            // "email" => "test1@test.com"
            // ]
            $product = Product::where('id', $item->product_id)
                ->select('id', 'name', 'price')->get()->toArray();//商品情報の配列
            $quantity = Cart::where('product_id', $item->product_id)
                ->select('quantity')->get()->toArray();//在庫数の配列
            // dd($ownerInfo, $product, $quantity);
            $result = array_merge($product[0], $ownerInfo, $quantity[0]);//配列の結合
            // dd($result);
            array_push($products, $result);//配列に追加
        }
        // dd($products);
        return $products;
    }
}
