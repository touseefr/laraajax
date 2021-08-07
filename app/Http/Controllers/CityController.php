<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
//use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Validator;

class CityController extends Controller
{
    //
    public function addcity(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'city_name' => 'required',
            'image' => 'required|image|mimes:jgp,jpeg,png'
        ]);
        if ($validate->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validate->errors(),
            ]);
        } else {
            $city = new City;
            $city->state_id = $request->state_id;
            $city->city_name = $request->city_name;
            //  $city->image=$request->file;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $fname = $file->getClientOriginalName();
                //$filenmae=time(). "." .$extension  //with time extension
                $filename = $fname;     //with original filename
                $file->move('cities', $filename);
                $city->image = $filename;
            }
            //  dd($city);
            $city->save();
        }
        // if ($result) {
        //     return response()->json([
        //         'message' => 'data inserted',
        //         'code' => 200
        //     ]);
        // } else {
        //     return response()->json([
        //         'message' => 'data failed',
        //         'code' => 402
        //     ]);
        // }
    }
    public function getcities()
    {
        $cities = City::select('cities.id', 'cities.image', 'cities.city_name', 'cities.status', 'states.state_name')->join('states', 'states.id', '=', 'cities.state_id')->get();
        //    $cities = City::withTrashed()->select('cities.id', 'cities.city_name', 'cities.status', 'states.state_name')->join('states', 'states.id', '=', 'cities.state_id')->get(); 
        // dd($cities);
        if ($cities) {
            return response()->json([
                'message' => 'success',
                'code' => 200,
                'data' => $cities
            ]);
        } else {
            return response()->json([
                'message' => 'failed',
                'code' => 403
            ]);
        }
    }
    //bin
    public function bin()
    {
        // $cities = City::select('cities.id', 'cities.city_name', 'cities.status', 'states.state_name')->join('states', 'states.id', '=', 'cities.state_id')->get();
        $cities = City::select('cities.id',  'cities.city_name', 'cities.status', 'states.state_name')->join('states', 'states.id', '=', 'cities.state_id')->onlyTrashed()->get();
        //dd($cities);
        return view('bin', compact('cities'));
    }
    //restore
    public function restore(Request $request, $id)
    {
        $city = City::withTrashed()->where('id', $id)->first();
        //dd($city);
        $city->restore();
        return back();
    }
    //edit
    public function getCityById(Request $request)
    {
        $result = City::where('id', $request->id)->first();
        // dd($result);
        if ($result) {
            return response()->json([
                'message' => 'success edit',
                'code' => 200,
                'data' => $result
            ]);
        } else {
            return response()->json([
                'message' => 'failed edit',
                'code' => 403
            ]);
        }
    }
    //update
    public function update(Request $request)
    {
        // dd("update here");
        $city = City::where('id', $request->id)->first();
        //  dd($city);
        // $this->allupdate($request);
        if ($request->has('image')) {
        $validate = Validator::make($request->all(), [
            'edit_city_name' => 'required',
            //  'image' => 'required|image|mimes:jgp,jpeg,png'
        ]);
        if ($validate->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validate->errors(),
            ]);
        }
        }
        else{
            $validate = Validator::make($request->all(), [
                'edit_city_name' => 'required',
                //  'image' => 'required|image|mimes:jgp,jpeg,png'
            ]);
            if ($validate->fails()) {
                return response()->json([
                    'status' => 400,
                    'errors' => $validate->errors(),
                ]);
            }
        }
        dd('yes reach there');
        $city->state_id = $request->edit_state_id;
        $city->city_name = $request->edit_city_name;
        $city->status = $request->edit_status;
        $result = $city->save();

        if ($result) {
            return response()->json([
                'message' => 'success update',
                'status' => 200,
            ]);
        } else {
            return response()->json([
                'message' => 'failed failed update',
                'status' => 400
            ]);
        }
    }
    public function allupdate($request)
    {
        if ($request->has('image')) {
            //dd('yes');
            $res = $request->validate([
                'edit_city_name' => 'required',
                'image' => 'mimes: jpg,jped'
            ]);

            if ($res->fails()) {
                return response()->json([
                    'errors' => $res->errors(),
                    'code' => 400,
                ]);
            }
        } else {
            // dd('no');
            $validate = Validator::make($request->all(), [
                'city_name' => 'required',
                //  'image' => 'required|image|mimes:jgp,jpeg,png'
            ]);
            if ($validate->fails()) {
                return response()->json([
                    'status' => 400,
                    'errors' => $validate->errors(),
                ]);
            }
        }
    }
    //dleete
    public function delete(Request $request)
    {
        $city = City::where('id', $request->id)->first();
        $result = $city->delete();

        if ($result) {
            return response()->json([
                'message' => 'success delete',
                'code' => 200,
            ]);
        } else {
            return response()->json([
                'message' => 'failed delete',
                'code' => 403
            ]);
        }
    }
}
