<?php

namespace App\Http\Controllers;
use App\Models\Cart;
use App\Models\Tovar;
use App\Models\Cart_tovar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Backery;


class CartController extends Controller
{
    public function constructor(Request $request){
        $cart = Cart::where('id', session('cart_id'))->first();
        if (!$cart) {
            $cart = new Cart;
            $cart->timestamps = false;
            $cart->save();

            session(['cart_id' => $cart->id]);
        }
        $validation = $request->validate([
            'quantity' => 'required'
        ]);
        $tovar = new Tovar;
        $tovar->timestamps=false;
        $tovar->name = 'Konstructor';
        $chocolate = ['Білий шоколад', 'Чорний шоколад', 'Молочний шоколад'];
        $wrapper = ['Паперова', 'Пластикова', 'Подарункова'];
        $filling = ['Карамель','Манго','Лохина'];
        $x = $chocolate[$request->input('chocolate')];
        $y = $chocolate[$request->input('wrapper')];
        $c = $chocolate[$request->input('filling')];
        $tovar->composition = "$x, $c, $y";
        $tovar->type_id = 1;
        $tovar->weight_id = 2;
        $tovar->ready = 0;
        $tovar->inaccessible = 0;
        $tovar->no_lactose = 0;
        $tovar->no_nuts = 1;
        $tovar->no_gluten = 1;
        $tovar->sale = 0;
        $tovar->new = 1;
        $tovar->image = 'https://cdn.shopify.com/s/files/1/0279/6329/3831/products/IMG_7057_1024x1024.jpg?v=1649306527';
        $tovar->price = 57.30;
        $tovar->save();
        $cart_tovar = new Cart_tovar();
        $cart_tovar->cart_id = $cart->id;
        $cart_tovar->tovar_id = $tovar->id;
        $cart_tovar->number = $request->input('quantity')/100;
        $cart_tovar->timestamps = false;
        $cart_tovar->save();
        return redirect('/catalog');
    }

    public function store($id){
        $tovar_id = $id;
        $cart = Cart::where('id', session('cart_id'))->first();
        $tovar_number = Cart_tovar::where('cart_id', '=', );
        if (!$cart) {
            $cart = new Cart;
            $cart->timestamps = false;
            $cart->save();

            session(['cart_id' => $cart->id]);
        }
        $tovar_number = Cart_tovar::where('cart_id', '=', $cart->id)->where('tovar_id', '=', $id)->first();
        if($tovar_number){
            $tovar_number->number+=1;
            $tovar_number->timestamps=false;
            $tovar_number->update();
        }
        else{
            $cart->tovars()->attach($tovar_id);
        }
    }
    public function store_main($id){
        self::store($id);
        return redirect('/');
    }
    public function store_catalog($id){
        self::store($id);
        return redirect('/catalog');
    }
    public function store_tovar($id){
        self::store($id);
        return redirect("/tovar/$id");
    }

    public function cart(){
        $cart = Cart::where('id', session('cart_id'))->with('tovars')->first();
        if (!$cart) {
            $cart = new Cart;
            $cart->timestamps = false;
            $cart->save();
            session(['cart_id' => $cart->id]);
        }
        if ($cart) {
            $tovars = $cart->tovars;
            $numbers = array();
            $price = array();
            foreach($tovars as $x){
                $tovar_number = Cart_tovar::where('cart_id', '=', $x->pivot->cart_id)->where('tovar_id', '=', $x->pivot->tovar_id)->first();
                $numbers[$x->id] = $tovar_number->number;
                $price[$x->id] = $tovar_number->number*$x->price;
            }
        } 
        return view('cart', compact('tovars', 'numbers'), compact('price'));
    }

    public function delete($id){
        $cart = Cart::where('id', session('cart_id'))->first();
        $tovar_id=$id;
        $cart->tovars()->detach($tovar_id);
        return self::cart();
    }
    public function buying(Request $request){
        $validation = $request->validate([
            'name' => 'required',
            'phone' => 'required'
        ]);
        $request->session()->flush();
        return view('submit');
    }
}
