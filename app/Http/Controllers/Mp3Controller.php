<?php

namespace App\Http\Controllers;

use App\Mp3;
use Illuminate\Http\Request;
use App\Http\Requests\Mp3Request;
use App\Http\Resources\Mp3Resource;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class Mp3Controller extends BaseController
{

    public function __construct()
    {
        $this->middleware('auth:api')->except(['index','downloadMp3']);
        // $this->middleware('scopes:create-mp3,update-mp3')->only(['store','update']);

    }

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

      //
/**
 * @OA\Get(
 *     path="/api/mp3",
 *     tags={"mp3 controller"},
 *     description="This endpoints query out all mp3 records.",
 *     summary="GET mp3 records",
 *     @OA\Response(response="200", description="Successfully Operation"),
 *     @OA\Response(response="400", description="Bad Request")
 * )
 */
    public function index()
    {
        //
        // $mp3 = Mp3::latest()->get();
        $mp3 = Cache::remember('mp3',2,function(){
            return Mp3::latest()->get();
        });

        return $this->sendResponse(Mp3Resource::collection($mp3));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */





    /**
     *     @OA\Post(
     *     path="/api/mp3",
     *     tags={"mp3 controller"},
     *     description="This endpoints create a new  mp3 record.",
     *     summary="Create mp3 record",
     *     operationId="createMp3",
     *     @OA\RequestBody(
     *          required=true,
     *          description="Created mp3 object",
    *           @OA\MediaType(
    *               mediaType="multipart/form-data",
    *               @OA\Schema(ref="#/components/schemas/Mp3")
    *           )
     *      ),
     *     @OA\Response(
     *          response="200",
     *          description="Successfully Operation",
     *           @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Mp3")
     *         )
     *      ),
     *     @OA\Response(response="400", description="Bad Request")
     * )
     */
        
    public function store(Mp3Request $request)
    {
        

        $mp3 = new Mp3;
        $mp3->artist_name = $request->artistName;
        $mp3->song_genre = $request->songGenre;
        $mp3->downloadable = $request->downloadable;

        if($request->hasFile('songThumbnail'))
        {
            $image = $request->file('songThumbnail');

            $filename  = $image->getClientOriginalName();
            $filesize  = $image->getSize();
            $filextension = $image->getClientOriginalExtension();
            $file_title = time().'.' .$filextension;

        }

        if($request->hasFile('songName'))
        {
            $song = $request->file('songName');
            $song_name  = $song->getClientOriginalName();
            $song_size  = $song->getSize();
            $song_mime  = $song-> getMimeType();
           
            $song_extension = $song->getClientOriginalExtension();      
            $song_title = time().'.' .$song_extension;

            $only_name = explode('.'.$song_extension,$song_name)[0];

        }

        if(config('app.env')=='production'){
            $image_path = $image->store('soundinsights_images', 's3');
            $song_path= $song->store('soundinsights_mp3','s3');      
            Storage::disk('s3')->setVisibility($image_path,'public');
            Storage::disk('s3')->setVisibility($song_path,'public');
            $mp3->song_thumbnail = Storage::disk('s3')->url($image_path);
    
            $mp3->song_extension = $song_extension;
            $mp3->song_size = $song_size;
            $mp3->tempname_song = basename($song_path);
            $mp3->tempname_image = basename($image_path);
           
            $mp3->song_title = Storage::disk('s3')->url($song_path);
            $mp3->song_name = $only_name;
            $mp3->save(); 

        }
        
        if(config('app.env')=='local')
        { 
            $mp3->song_thumbnail = $file_title;
            $mp3->song_extension = $song_extension;
            $mp3->song_size = $song_size;
            // $song_title goes to DB and should be called to display on front-end
            $mp3->song_title = $song_title;
            $mp3->song_name = $only_name;
            $mp3->save(); 
            // upload file to public folder if request is successful
            $song -> move('soundinsight/mp3/' , $song_title);
            $image -> move('soundinsight/img/' , $file_title);
        }
      

        return $this->sendResponse($mp3,"Mp3 successfully added");

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Mp3  $mp3
     * @return \Illuminate\Http\Response
     * 
     * 
     */
    /**
     * @OA\Get(
     *      path="/api/mp3/{id}",
     *      operationId="getMp3ById",
     *      tags={"mp3 controller"},
     *      summary="Get mp3 record",
     *      description="Returns single mp3  information",
     *      @OA\Parameter(
     *          name="id",
     *          description="id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function show(Mp3 $mp3)
    {
        //
        return $this->sendResponse(new Mp3Resource($mp3));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Mp3  $mp3
     * @return \Illuminate\Http\Response
     */

   
    public function update(Request $request, Mp3 $mp3)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Mp3  $mp3
     * @return \Illuminate\Http\Response
     */

        /**
     * @OA\Delete(
     *      path="/api/mp3/{id}",
     *      operationId="deleteProject",
     *      tags={"mp3 controller"},
     *      summary="Delete existing mp3 record",
     *      description="Deletes a record and returns no content",
     *      @OA\Parameter(
     *          name="id",
     *          description="id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
    public function destroy($id)
    {
        //
            $mp3 = Mp3::findOrFail($id);
            
            // if(!$mp3)
            // {
            //     return $this->errorResponse("The mp3 does not exist",404);
            // }

            Storage::disk('s3')->delete('soundinsights_mp3/'.$mp3->tempname_song);
            Storage::disk('s3')->delete('soundinsights_images/'.$mp3->tempname_image);

            $mp3->delete();
            return $this->sendResponse("Record removed");

    }



     /**
     * @OA\Get(
     *      path="/api/mp3/download/{id}",
     *      operationId="downloadMp3ById",
     *      tags={"mp3 controller"},
     *      summary="download mp3 record",
     *      description="Download mp3  record",
     *      @OA\Parameter(
     *          name="id",
     *          description="id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */

    public function downloadMp3($id)
    {
        // application/octet-stream

        $mp3 = Mp3::findOrFail($id);
        $name=$mp3->song_name.'.'.$mp3->song_extension;
        $headers = [

            'content-type'=>'audio/mpeg',
            'Content-Disposition' => ' attachment; filename="'.$name.'"',
        ];

        return Storage::disk('s3')->download('soundinsights_mp3/'.$mp3->tempname_song, $name, $headers);


    }



}
