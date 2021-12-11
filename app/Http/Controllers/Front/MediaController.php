<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use App\Models\Media;
use Faker\Core\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\File as FileFacade;


class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $media = Media::where('is_online','=',1)->get();
        //->orderBy('created_at', 'desc')->simplePaginate(20);
        return $media->toJson(JSON_PRETTY_PRINT);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate(
            [
                'url_video' => 'required | string',
                'texte' => 'required | string | max:250',
                'title' => 'required | string | max:100',
                'pays_id'=> 'required',
                'lien_facebook' => 'string',
                'lien_instagram' => 'string',
                'image' =>  'required|image|max:1999',
                'categories'=> 'required',
            ]
        );
        if ($request->hasFile('image')) {
            $uniqid = uniqid();

            // Recuperer le nom de l'image saisi par l'utilisateur
            $fileName = $request->file('image')->getClientOriginalName();

            //Telechargement de l'image
            $request->file('image')->storeAs('public/upload', $uniqid.$fileName);

            $img = Image::make($request->file('image')->getRealPath());

            //Dimensionner l'image
            $img->resize(500, 500);

            // Imprimer l'icon sur l'image
            $img->insert(public_path('img/icon/logo_color.png'), 'bottom-right', 5, 5);

            $img->save('storage/image/'.$uniqid.$fileName);
        }

        $media = new Media();
        $media->url_video = $request->url_video;
        $media->lien_facebook = $request->lien_facebook;
        $media->lien_instagram = $request->lien_instagram;
        $media->texte = $request->texte;
        $media->title = $request->title;
        $media->pays_id = $request->pays_id;
        $media->image = $uniqid.$fileName;
        if ($request->categories) {
            foreach ($request->categories as $id) {
                $media->categories()->attach($id);
            }
        }
        $media->save();

        return response()->json([JSON_PRETTY_PRINT,
        'message'=>'successful!',
        'status'=>true,
        'media' => $media,
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
        //
        $media = Media::find($id);

        return $media->toJson(JSON_PRETTY_PRINT);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id )
    {
        $media = Media::find($id);
        $request->validate(

            [
                'url_video' => 'required | string',
                'texte' => 'required | string | max:250',
                'title' => 'required | string | max:100',
                'pays_id'=> 'required',
                'lien_facebook' => 'string',
                'lien_instagram' => 'string',
                'image' =>  'required|image|max:1999',
                'categories'=> 'required'
            ]

        );

        if ($request->hasFile('image')) {
            $uniqid = uniqid();

            // Recuperer le nom de l'image saisi par l'utilisateur
            $fileName = $request->file('image')->getClientOriginalName();

            $img = Image::make($request->file('image')->getRealPath());

            //Dimensionner l'image
            $img->resize(500, 500);

            // Imprimer l'icon sur l'image
            $img->insert(public_path('img/icon/logo_color.png'), 'bottom-right', 5, 5);

            $img->save(public_path('storage/image/'.$uniqid.$fileName));
        }

        $media->url_video = $request->url_video;
        $media->lien_facebook = $request->lien_facebook;
        $media->lien_instagram = $request->lien_instagram;
        $media->texte = $request->texte;
        $media->title = $request->title;
        $media->pays_id = $request->pays_id;
        $media->image = $uniqid.$fileName;
        if ($request->categories) {
            foreach ($request->categories as $id) {
                $media->categories()->attach($id);
            }
        }
        $media->save();
        return response()->json([JSON_PRETTY_PRINT,
        'message'=>'successful!',
        'status'=>true,
        'media' => $media,
         ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Media::destroy($id);
    }

    /**
     * Search for a name.
     *
     * @param  str  $texte
     * @return \Illuminate\Http\Response
     */
    public function search($texte)
    {
        return Media::where('texte','like','%'. $texte .'%')->get();
    }

}
