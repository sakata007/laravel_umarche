<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Services\CartService;
use App\Jobs\SendThanksMail;



class CartController extends Controller
{
    public function index()
    {
        $user = User::findOrFail(Auth::id());
        $products = $user->products;
        $totalPrice = 0;

        foreach($products as $product) {
            $totalPrice += $product->price * $product->pivot->quantity;
        }

        // dd($products, $totalPrice);

        return view('user.cart', compact('products', 'totalPrice'));
    }

    public function add(Request $request)
    {
        // dd($request);
        $itemInCart = Cart::where('product_id', $request->product_id)
        ->where('user_id', Auth::id())
        ->first();

        if($itemInCart) {
            $itemInCart->quantity += $request->quantity;
            $itemInCart->save();
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity
            ]);
        }
        // dd('テスト');
        return redirect()->route('user.cart.index');
    }

    public function delete($id)
    {
        Cart::where('product_id', $id)
        ->where('user_id', Auth::id())
        ->delete();

        return redirect()->route('user.cart.index');
    }

    public function checkout()
    {
        //
        $items = Cart::where('user_id', Auth::id())->get();
        $products = CartService::getItemsInCart($items);
        $user = User::findOrFail(Auth::id());

        SendThanksMail::dispatch($products, $user);
        dd('ユーザーメール送信テスト');
        //
        $user = User::findOrFail(Auth::id());
        $products = $user->products;

        $lineItems = [];
        foreach($products as $product) {
            $quantity = '';
            $quantity = Stock::where('product_id', $product->id)->sum('quantity');

            if($product->pivot->quantity > $quantity) {
                return redirect()->route('user.cart.index');
            } else {
                $lineItem = [
                    'name' => $product->name,
                    'description' => $product->infomation,
                    'amount' => $product->price,
                    'currency' => 'jpy',
                    'quantity' => $product->pivot->quantity,
                ];
                array_push($lineItems, $lineItem);
            }

                foreach($products as $product) {
                    Stock::create([
                        'product_id' => $product->id,
                        'type' => \Constant::PRODUCT_LIST['reduce'],
                        'quantity' => $product->pivot->quantity * -1,
                    ]);
                }
        }

        // dd($lineItems);
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            // 'line_items' => [$lineItems],
            // 'line_items' => [[
            //     'price_data' => [
            //         'currency' => 'usd',
            //         'unit_amount' => 2000,
            //         'product_data' => [
            //             'name' => 'T-shirt',
            //             'description' => 'Comfortable cotton t-shirt',
            //             'images' => ['https://example.com/t-shirt.png'],
            //         ],
            //     ],
            //     'quantity' => 1,
            // ]],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'unit_amount' => $product->price,
                    'product_data' => [
                        'name' => $product->name,
                        'description' => $product->infomation,
                        // 'images' => ['https://example.com/t-shirt.png'],
                    ],
                ],
                'quantity' => $product->pivot->quantity,
            ]],

            'mode' => 'payment',
            'success_url' => route('user.cart.success'),
            'cancel_url' => route('user.cart.cancel'),
        ]);

        $publickey = env('STRIPE_PUBLIC_KEY');

        return view('user.checkout', compact('session', 'publickey'));

    }

    public function success()
    {
        Cart::where('user_id', Auth::id())
        ->delete();

        return redirect()->route('user.items.index');
    }

    public function cancel()
    {
        $user = User::findOrFail(Auth::id());

        foreach($user->products as $product) {
            Stock::create([
                'product_id' => $product->id,
                'type' => \Constant::PRODUCT_LIST['add'],
                'quantity' => $product->pivot->quantity
            ]);
        }
        return redirect()->route('user.cart.index');

    }
}
