<?php

namespace App\Http\Controllers;

use App\SugarClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;

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
        $name = Input::get('name');
        $guests = Input::get('guests');
        $attending = Input::get('attending');
        $guests = ($attending?intval($guests):0);
        $error = '';
        if (isset($name) && ($guests >= 0) && isset($attending)){
            $id = DB::table('pre_rsvp')->insertGetId(
                array(
                    'name' => $name,
                    'guests' => $guests,
                    'attending' => $attending
                )
            );
            Log::info("$id was inserted into the Pre-RSVP table.");
        }
        return redirect('/ceremony#rsvp');
    }



}