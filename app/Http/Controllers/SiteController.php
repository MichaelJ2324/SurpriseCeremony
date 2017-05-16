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

    public function rsvp(){
        $name = Input::get('name');
        $attending = Input::get('attending');
        $guests = Input::get('guests');
        $chicken = Input::get('chicken');
        $beef = Input::get('beef');
        $vegan = Input::get('vegan');
        if (empty($attending) || !$attending){
            $guests = 0;
            $chicken = 0;
            $beef = 0;
            $vegan = 0;
        }
        if (isset($name)){
            $rsvp = DB::table('rsvps')->where('confirmation_code',$name)->first();
            if (empty($rsvp)) {
                $id = DB::table('rsvps')->insertGetId(
                    array(
                        'name' => $name,
                        'attending' => $attending,
                        'guests' => $guests,
                        'chicken' => $chicken,
                        'beef' => $beef,
                        'vegan' => $vegan,
                        'confirmation_code' => str_random(16)
                    )
                );

                $rsvp = DB::table('rsvps')->where('id', $id)->first();
            } else {
                DB::table('rsvps')->where('id',$rsvp->id)->update(array(
                    'attending' => $attending,
                    'guests' => $guests,
                    'chicken' => $chicken,
                    'beef' => $beef,
                    'vegan' => $vegan
                ));
            }
            return json_encode(array(
                    'success' => 'Confirmation code: '.$rsvp->confirmation_code
                ));
        } else {
            return json_encode(array(
                'error' => 'Name was not provided'
            ));
        }
    }



}