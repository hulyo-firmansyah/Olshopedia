<?php

namespace App;

use Illuminate\Http\Request;

class Cart {

    public static function addCart(Request $request, $id, $jumlah, $data){
        if($request->session()->has('cart')){
            $cart = $request->session()->get('cart');
        } else {
            $cart = [];
        }

        if(isset($cart[$id])){
            $cart[$id]->jumlah += $jumlah;
        } else {
            $cart[$id] = new \stdclass();
            $cart[$id]->id = $id;
            $cart[$id]->jumlah = $jumlah;
            $cart[$id]->data = $data;
        }

        $request->session()->put('cart', $cart);
    }

    public static function getCart(Request $request){
        if($request->session()->has('cart')){
            return $request->session()->get('cart');
        } else {
            return [];
        }
    }

    public static function removeCart(Request $request, $id){
        if($request->session()->has('cart')){
            $cart = $request->session()->get('cart');
            if(isset($cart[$id])) unset($cart[$id]);
            $request->session()->put('cart', $cart);
        }
    }

    public static function kosongCart(Request $request){
        $request->session()->forget('cart');
    }
}