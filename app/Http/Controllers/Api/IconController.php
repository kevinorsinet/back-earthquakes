<?php

namespace App\Http\Controllers\Api;

use App\Models\Icon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\IconRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\IconResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class IconController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $icons =  Icon::all();
       return new IconResource($icons);
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
          'image' => 'required',
          'image.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
  
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
  
        $filename="";
        if($request->hasFile('image')){

            // On récupère le nom du fichier sans son extension, résultat $filenameWithExt : "soccer"
            $filenameExt = $request->file('image')->getClientOriginalName();
            $filenameWithoutExt = pathinfo($filenameExt, PATHINFO_FILENAME);

             
          //  On récupère l'extension du fichier, résultat $extension : ".jpg"
          $extension = $request->file('image')->getClientOriginalExtension();
       
          // On crée un nouveau fichier avec le nom + une date + l'extension, résultat $fileNameToStore : "soccer_20220422.jpg"
          $filename = $filenameWithoutExt.'_'.time().'.'.$extension;
        
          // On enregistre le fichier à la racine /storage/app/public/uploads, ici la méthode storeAs définit déjà le chemin /storage/app
          $path = $request->file('image')->storeAs('public/uploads',$filename);
  
        } else {
            $filename='defaultImage.jpg';
        }
  
        $icon = Icon::create([
          'name' => $request->name,
          'image' => $filename,
        ]);
  
        return response()->json([
          'status' => 'Success',
          'data' => $icon,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Icon  $icon
     * @return \Illuminate\Http\Response
     */
    public function show(Icon $icon)
    {
        $icon = Icon::find($icon);

        if(is_null($icon)) {
          return $this->sendError("Cette icone n'existe pas.");
        }
        return response()->json([
          'status' => 'Success',
          'data' => $icon,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Icon  $icon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Icon $icon)
    {

        $request->validate([ 
          'image.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        
        // $iconUpdate = Icon::find($icon);
        $iconUpdate = $request->all();
        $filename="";
        if($request->hasFile('image')){

          // On récupère le nom du fichier sans son extension, résultat $filenameWithExt : "soccer"
          $filenameExt = $request->file('image')->getClientOriginalName();
          $filenameWithoutExt = pathinfo($filenameExt, PATHINFO_FILENAME);

          //  On récupère l'extension du fichier, résultat $extension : ".jpg"
          $extension = $request->file('image')->getClientOriginalExtension();
       
          // On crée un nouveau fichier avec le nom + une date + l'extension, résultat $fileNameToStore : "soccer_20220422.jpg"
          $filename = $filenameWithoutExt.'_'.time().'.'.$extension;
          $iconUpdate['image'] = $filename;
          // On enregistre le fichier à la racine /storage/app/public/uploads, ici la méthode storeAs définit déjà le chemin /storage/app
          $path = $request->file('image')->storeAs('public/uploads',$filename);
          
        } else {
          unset($iconUpdate['image']);
        }
        $icon->update($iconUpdate);
        // var_dump($request->file('image')->getClientOriginalName());
        // die();
        return response()->json([
          'status' => 'Success',
          'data' => $icon
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Icon  $icon
     * @return \Illuminate\Http\Response
     */
    public function destroy(Icon $icon)
    {
        $icon->delete();
        return response()->json([
            'status' => 'Icone supprimée '
        ]);
    }
}
