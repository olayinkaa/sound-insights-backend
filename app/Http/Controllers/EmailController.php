<?php

namespace App\Http\Controllers;

use App\Email;
use Illuminate\Http\Request;
use App\Mail\CustomerEnquiry;
use App\Http\Requests\EmailRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EmailController extends BaseController
{

     /**
     *     @OA\Post(
     *     path="/api/sendmail",
     *     tags={"email controller"},
     *     description="This endpoints send an email",
     *     summary="send email",
     *     operationId="sendEmail",
     *     @OA\RequestBody(
     *          required=true,
     *          description="Created email object",
    *           @OA\MediaType(
    *               mediaType="application/json",
    *               @OA\Schema(ref="#/components/schemas/Email")
    *           )
     *      ),
     *     @OA\Response(
     *          response="200",
     *          description="Successfully Operation",
    *           @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Email")
     *         )
     *      ),
     *     @OA\Response(response="400", description="Bad Request")
     * )
     * 
     */
    public function customerEmail(EmailRequest $request)
    {
        $details = [
            'name'=> $request->name,
            'email'=>$request->email,
            'subject'=>$request->subject,
            'body'=>$request->body
        ];

        Log::notice($details);

        Mail::to("ibrahimolayinkaa@gmail.com")->send(new CustomerEnquiry($details));

        Log::info("Email sent successfully");

        return $this->showMessage("Your email message has being sent");
    }


    public function verify($token)
    {
        $user = User::where('verification_token',$token)->firstOrFail();
        $user->verified = User::VERIFIED_USER;
        $user->verification_token = null;

        $user->save();
        return $this->sendResponse("The account has been verified");

    }

}
