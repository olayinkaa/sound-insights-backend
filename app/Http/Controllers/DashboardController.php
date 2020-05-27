<?php

namespace App\Http\Controllers;

use App\Mp3;
use App\User;
use App\Dashboard;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $downloadable = Mp3::where('downloadable','1')->get()->count();
        $notdownloadable = Mp3::where('downloadable','0')->get()->count();
        $mp3 = Mp3::all()->count();
        $user = User::all()->count();

        return response()->json([
            'status'=>200,
            'success'=>true,
            'total_downloadable_mp3'=>$downloadable,
            'total_not_downloadable_mp3'=>$notdownloadable,
            'registerUser'=>$user
        ]);
    }

}
