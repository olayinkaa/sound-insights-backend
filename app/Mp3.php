<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * @OA\Schema(
 *     title="Mp3",
 *     description="Mp3 model",
 * )
 */

class Mp3 extends Model
{
    //

    /**
     * @OA\Property(
     *     description="Song Genre",
     *     title="genre",
     * )
     *
     * @var string
     */
    private $songGenre;

     /**
     * @OA\Property(
     *     description="Song Name",
     *     title="name",
     *     type="file",
     *     format="binary"
     * )
     *
     * @var string
     */
    private $songName;


      /**
     * @OA\Property(
     *     description="Song Thumbnail",
     *     title="thumbnail",
     *     type="file",
     *     format="binary"
     * )
     *
     * @var string
     */
    private $songThumbnail;

     /**
     * @OA\Property(
     *     description="Artist Name",
     *     title="Artist name",
     *    
     * )
     *
     * @var string
     */
    private $artistName;



    

    protected $fillable= [
        'song_title',
        'song_name',
        'artist_name',
        'song_thumbnail',
        'song_genre',
        'song_size',
        'song_extension'
    ];

    // protected $visible = ['song_title'];
    protected $hidden = ['song_title'];

    // accessors and mutator
    public function getArtistNameAttribute($name)
    {
        return ucwords($name);
    }

    public function getSongNameAttribute($name)
    {
        // return strtolower(trim($name));
        $getName = str_replace(' ', '-', $name);
        return $getName;
    }

    public function setSongNameAttribute($name)
    {
        $this->attributes['song_name'] = strtolower($name);
    }

}
