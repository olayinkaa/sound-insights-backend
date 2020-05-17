<?php

namespace App\Http\Resources;

use App\Mp3;
use Illuminate\Http\Resources\Json\JsonResource;


class Mp3Resource extends JsonResource
{



    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id'=>$this->id,
            'title'=>$this->song_title,
            'name'=>$this->song_name,
            'artist'=>$this->artist_name,
            'thumbnail'=>$this->song_thumbnail,
            'genre'=>$this->song_genre,
            'size'=>$this->song_size,
            'type'=>$this->song_extension,
            'downloadable'=>$this->downloadable,
        ];
    }
}
