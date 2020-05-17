<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;


trait ApiResponser
{


	public function successResponse($data,$code)
	{
		return response()->json(["data"=>$data],$code);
	}

     //
     public function sendResponse($result, $message="Successfully Processed",$code=200)
     {
         $response = [
             'success' => true,
             'status'=>$code,
             'message' => $message,
             'data'    => $result
         ];
 
 
         return response()->json($response, $code);
	 }
	 
     public function showMessage($message="Successfully Processed",$code=200)
     {
         $response = [
             'status'=>$code,
             'message' => $message,
         ];
 
 
         return response()->json($response, $code);
     }
 
     
     public function sendError($error, $errorMessages = [], $code = 404)
     {
         $response = [
             'success' => false,
             'message' => $error,
         ];
 
 
         if(!empty($errorMessages)){
             $response['data'] = $errorMessages;
         }
 
 
         return response()->json($response, $code);
     }

	protected function errorResponse($message,$code)
	{
		return response()->json([

			'error'=>$message,
			'code'=>$code

		],$code);

	}


	protected function showAll(Collection $collection, $code = 200 )
	{

		return $this->successResponse([

			'status'=>$code,
			'message'=>"Successful Processed",
			'content'=>$collection

		], $code);
	}


	protected function showOne(Model $model, $code=200)
	{

		return $this->successResponse([

			'status'=>$code,
			'message'=>'Successful processed',
			'content'=>$model

		],$code);
	}

	protected function sortData(collection $collection)
	{
		if(request()->has('sort_by'))
		{
			$attribute = request()->sort_by;

			$collection = $collection->sort_by->{attribute};

		}

		return $collection;
	}


}

