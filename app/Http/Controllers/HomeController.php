<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{


    public function index(){
        $products = [];
        $response = null;
        if(auth()->user()->token){
            $response = Http::withHeaders([
                'Accept'        => 'application/json',
                'Authorization' => 'Bearer ' . auth()->user()->token->access_token
            ])->get('http://127.0.0.1:8000/api/products');
        }

        if($response && $response->status() == 200){
            $products = $response->json();
        }

        return view('dashboard', ['products' => $products]);
    }



}
