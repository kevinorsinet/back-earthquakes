<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\CountryEarthquakeRequest;
use App\Http\Resources\CountryEarthquakeResource;

class CountryEarthquakeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $country_earthquake = DB::table('country_earthquake')
        ->get();

        return new CountryEarthquakeResource($country_earthquake);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CountryEarthquakeRequest $request)
    {
        $countryEarthquake = DB::insert('insert into country_earthquake (country_id, earthquake_id) values (?, ?)', [$request->country_id,$request->earthquake_id]);
        return response()->json([
            'status' => 'Success',
            'data' => $countryEarthquake
          ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $countryEarthquake = DB::table('country_earthquake')
        ->where('country_earthquake.id', '=', $id)
        ->get()->toArray();
        
        return response()->json([
            'status' => 'Success',
            'data' => $countryEarthquake
          ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $country_earthquake = DB::table('country_earthquake')->where('country_earthquake.id', '=', $id)->delete();
        return response()->json([
            'status' => 'Suppression effectuée'
          ]);

    }
}
