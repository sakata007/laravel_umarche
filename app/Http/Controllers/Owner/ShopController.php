<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Shop;
use InterventionImage;
use App\Http\Requests\UploadImageRequest;

class ShopController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:owners');

        $this->middleware(function($request, $next) {
            // dd($request->route()->parameter('shop')); //文字列
            // dd(Auth::id()); //数字
                $id = $request->route()->parameter('shop'); //shopのid取得
                if(!is_null($id)) {
                    $shopOwnerId = Shop::findOrFail($id)->owner->id;
                    $shopId = (int)$shopOwnerId; //キャスト　文字列→数値に型変換
                    $ownerId = Auth::id();
                    if($shopId !== $ownerId) {
                        abort(404);
                    }
                }
            return $next($request);
        });
    }

    public function index()
    {
        // phpinfo();
        // $owner_id = Auth::id();
        $shops = Shop::where('owner_id', Auth::id())->get();

        return view('owner.shops.index',
        compact('shops'));
    }
    public function edit($id)
    {
        // dd(Shop::findOrFail($id));
        $shop = Shop::findOrFail($id);
        return view('owner.shops.edit', compact('shop'));
    }
    public function update(UploadImageRequest $request, $id)
    {
        $imageFile = $request->image;
        if(!is_null($imageFile) && $imageFile->isValid()) {
            // Storage::putFile('public/shops', $imageFile);//リサイズなし

            $fileName = uniqid(rand(). '_'); //ランダムなファイル名を作成
            $extension = $imageFile->extension(); //拡張子を取得
            $fileNameToStore = $fileName . '.' . $extension; //作ったファイル名と拡張子を結合
            $resizedImage = InterventionImage::make($imageFile)->resize(1920, 1080)->encode(); //サイズを指定

            // dd($imageFile, $resizedImage);

            Storage::put('public/shops/' . $fileNameToStore, $resizedImage);
        };
        return redirect()->route('owner.shops.index');
    }
}
