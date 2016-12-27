<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class SiteController extends Controller {

    public function show()
    {
        return view('site');
    }

    public function viewCeremony(){
        return view('ceremony');
    }

    public function checkCode(Request $request){
        $redirect = '/';
        if (($code = strtoupper(Input::get('accessCode'))) == 'RUSSELL2017'){
            $request->session()->set('accessCode',$code);
            $redirect = '/ceremony';
        }
        return redirect($redirect);
    }

    public function preRSVP(){
        return view('ceremony');
    }



}