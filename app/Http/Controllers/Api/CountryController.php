<?php

namespace App\Http\Controllers\Api;

use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CountryResource;
use Illuminate\Support\Facades\Validator;


class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countries =  Country::all();
        return new CountryResource($countries);
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
            'flag' => 'required',
            'flag.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'risk' => 'required'
        ]);

  
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $filename="";
        if($request->hasFile('flag')){
  
        // On récupère le nom du fichier sans son extension, résultat $filenameWithExt : "soccer"
      
        $filenameExt = $request->file('flag')->getClientOriginalName();
        $filenameWithoutExt = pathinfo($filenameExt, PATHINFO_FILENAME);
             
        //  On récupère l'extension du fichier, résultat $extension : ".jpg"
        $extension = $request->file('flag')->getClientOriginalExtension();
       
          // On crée un nouveau fichier avec le nom + une date + l'extension, résultat $fileNameToStore : "soccer_20220422.jpg"
          $filename = $filenameWithoutExt.'_'.time().'.'.$extension;
        
          // On enregistre le fichier à la racine /storage/app/public/uploads, ici la méthode storeAs définit déjà le chemin /storage/app
          $path = $request->file('flag')->storeAs('public/uploads',$filename);
  
        } else {
            $filename='defaultImage.jpg';
        }
  
        $country = Country::create([
          'name' => $request->name,
          'flag' => $filename,
          'risk' => $request->risk
        ]);
  
        return response()->json([
          'status' => 'Success',
          'data' => $country,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function show(Country $country)
    {
        $country = Country::find($country);

        if(is_null($country)) {
          return $this->sendError("Ce pays n'existe pas.");
        }
        return response()->json([
          'status' => 'Success',
          'data' => $country,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Country $country)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function destroy(Country $country)
    {
        $country->delete();
        return response()->json([
            'status' => 'Suppression effectuée'
        ]);
    }
}
