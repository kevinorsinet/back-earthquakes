<?php

namespace App\Http\Controllers\Api;

use App\Models\Earthquake;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\EarthquakeResource;

class EarthquakeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $earthquakes =  Earthquake::all();
        return new EarthquakeResource($earthquakes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
    

        $validator = Validator::make($input, [
            'name' => 'required',
            'date' => 'required',
            'magnitude' => 'required',
            'radius' => 'required',
            'icon_id' => 'required'
          ]);
    
          if($validator->fails()){
              return $this->sendError('Validation Error.', $validator->errors());       
          }

        $earthquake = Earthquake::create([
          'name' => $request->name,
          'date' => $request->date,
          'magnitude' => $request->magnitude,
          'radius' => $request->radius,
          'icon_id'=>  $request->icon_id
          
        ]);
  
        return response()->json([
          'status' => 'Success',
          'data' => $earthquake,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Earthquake  $earthquake
     * @return \Illuminate\Http\Response
     */
    public function show(Earthquake $earthquake)
    {
        $earthquake = Earthquake::find($earthquake);

        if(is_null($earthquake)) {
          return $this->sendError("Ce séisme n'existe pas.");
        }
        return response()->json([
          'status' => 'Success',
          'data' => $earthquake,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Earthquake  $earthquake
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Earthquake $earthquake)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Earthquake  $earthquake
     * @return \Illuminate\Http\Response
     */
    public function destroy(Earthquake $earthquake)
    {
        $earthquake->delete();
        return response()->json([
            'status' => 'Suppression effeectué'
          ]);
    }
}
