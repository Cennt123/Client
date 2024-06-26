<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OAuthController extends Controller
{
    public function redirect(){
        $queries = http_build_query([
            'client_id' => 7,
            'redirect_uri' => 'http://127.0.0.1:8001/callback',
            'response_type' => 'code'
        ]);

        return redirect('http://127.0.0.1:8000/oauth/authorize?' . $queries);
    }

    public function callback(Request $request){
        $response = Http::post("http://127.0.0.1:8000/oauth/token", [
            'grant_type' => 'authorization_code',
            'client_id' => '7',
            'client_secret' => 'tNF7V9HXzAikJnCVDqRNQTx744u5jBXzAeal6MfO',
            'redirect_uri' => 'http://127.0.0.1:8001/callback',
            'code' => $request->code
        ]);

        $response = $response->json();

        $request->user()->token()->delete();
        $request->user()->token()->create([
            'access_token' => $response['access_token']
        ]);

        return redirect('/dashboard');
    }
}
