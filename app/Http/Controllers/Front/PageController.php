<?php

namespace App\Http\Controllers\Front;



use App\Http\Controllers\Controller;
use App\Models\Actualite;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    //
    public function voirCategorie(Request $request){
       $media = DB::table('media')
            ->join('categorie_media', 'media.id', '=', 'categorie_media.media_id')
            ->join('categories', 'categories.id', '=', 'categorie_media.categorie_id')
            ->where('categorie_id', '=', $request->id)->get();

        return response()->json([JSON_PRETTY_PRINT,
           'media' => $media,
        ]);
    }

    public function country(Request $request){

        $media = DB::table('media')
            ->where('is_online','=', 1)
            ->where('pays_id', '=',$request->id)->get();
            return response()->json([JSON_PRETTY_PRINT,
            'media' => $media,
         ]);
   }

}
