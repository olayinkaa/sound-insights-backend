<?php

namespace App\Http\Controllers;

use App\AboutUs;
use Illuminate\Http\Request;
use App\Http\Requests\AboutUsRequest;
use App\Http\Resources\AboutUsResource;

class AboutUsController extends BaseController
{

    public function __construct()
    {
        $this->middleware('auth:api')->except(['index','store']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get(
     *     path="/api/aboutus",
     *     tags={"about controller"},
     *     description="This endpoints query out all about-us records.",
     *     summary="GET about-us records",
     *     @OA\Response(response="200", description="Successfully Operation"),
     *     @OA\Response(response="400", description="Bad Request")
     * )
     */
    public function index()
    {
        //
        $aboutus = AboutUs::all();

        if(!$aboutus)
        {
            return $this->errorResponse("The about us content does not exist",404);
        }


        return $this->sendResponse(AboutUsResource::collection($aboutus));
            
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */     
    /**
     * @OA\Post(
     *     path="/api/aboutus",
     *     tags={"about controller"},
     *     description="This endpoints create a new  about-us record.",
     *     summary="Create about-us record",
     *     operationId="createAboutUs",
     *     @OA\RequestBody(
     *          required=true,
     *          description="Created About-us object",
    *           @OA\MediaType(
    *               mediaType="application/json",
    *               @OA\Schema(ref="#/components/schemas/AboutUs")
    *           )
     *      ),
     *     @OA\Response(
     *          response="200",
     *          description="Successfully Operation",
     *           @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/AboutUs")
     *         )
     *      ),
     *     @OA\Response(response="400", description="Bad Request")
     * )
     */
    public function store(AboutUsRequest $request)
    {
        //
        $count = AboutUs::latest()->get()->count();

        if($count==1){
            return response()->json(['data'=>"Record limit exceeded, delete or update existing record "],400);
        }
        $aboutus = AboutUs::create($request->all());
        return response()->json([
            'success'=>true,
            'message'=>"Successfully created",
            'data'=>$aboutus
        ],200);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AboutUs  $aboutUs
     * @return \Illuminate\Http\Response
     */
       
    /**
     * @OA\Get(
     *      path="/api/aboutus/{id}",
     *      operationId="getMp3ById",
     *      tags={"about controller"},
     *      summary="Get mp3 record",
     *      description="Returns single about-us information",
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
    public function show(AboutUs $aboutus)
    {
        //
        return $this->sendResponse(new AboutUsResource($aboutus));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AboutUs  $aboutUs
     * @return \Illuminate\Http\Response
     */
      /**
     * @OA\Put(
     *     path="/api/aboutus/{id}",
     *     tags={"about controller"},
     *     description="This endpoints create a new  about-us record.",
     *     summary="Update about-us record",
     *     operationId="updateAboutUs",
     *     @OA\RequestBody(
     *          required=true,
     *          description="Created About-us object",
    *           @OA\MediaType(
    *               mediaType="application/json",
    *               @OA\Schema(ref="#/components/schemas/AboutUs")
    *           )
     *      ),
     *      @OA\Parameter(
     *          name="id",
     *          description="id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Response(
     *          response="200",
     *          description="Successfully Operation",
     *           @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/AboutUs")
     *         )
     *      ),
     *     @OA\Response(response="400", description="Bad Request")
     * )
     */
    public function update(AboutUsRequest $request, AboutUs $aboutus)
    {
        //
        $aboutus->title = $request->title;
        $aboutus->description = $request->description;
        if($aboutus->isClean())
        {
            return response()->json([
                'data'=>"No Changes detected!"
            ],200);
        }
        $aboutus->update();
        return response()->json([
            "success"=>true,
            "message"=>"Successfully Updated",
            "data"=>$aboutus
        ],200);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AboutUs  $aboutUs
     * @return \Illuminate\Http\Response
     */


     /**
     * @OA\Delete(
     *      path="/api/aboutus/{id}",
     *      operationId="deleteProject",
     *      tags={"about controller"},
     *      summary="Delete existing about-us record",
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
     *          response=200,
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
    public function destroy(AboutUs $aboutus)
    {
        //
        $aboutus->delete();
        return response()->json([
            "success"=>true,
            "data"=>"About us record successfully removed"
        ],200);
    }
}
