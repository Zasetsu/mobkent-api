<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;

class HelperController extends Controller
{

    public function cities() {
        $cities = DB::table('iller')->get();
        return response()->json(['success' => true, 'data' => $cities],200);
    }

    public function towns(Request $request) {
        $towns = DB::table('ilceler')->where('il_id', $request->city_id)->get();
        return response()->json(['success' => true, 'data' => $towns],200);
    }


}
