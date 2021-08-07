<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\State;

class StateController extends Controller
{
    //
    public function getstate()
    {
        $states=State::all();
      //  dd($states);
        return view('state',compact('states'));
    }
}
