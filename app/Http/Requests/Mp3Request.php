<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Mp3Request extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            //
            // 'songName'=>'required|mimes:application/octet-stream,audio/mpeg,mpga,mp3,wav|max:10048',
            'songName'=>'required|max:10048',
            'artistName'=>'required',
            'songThumbnail'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'songGenre'=>'required',
            'downloadable'=>'required',
        ];


        return $rules;


        
    }

    public function messages()
    {
        return [
            'songName.max' => 'The size can not be greater than 2048 kilobytes.',
            'songName.mimes' => 'Only mp3 audio file is allowed',
        ];
    }



    
}
