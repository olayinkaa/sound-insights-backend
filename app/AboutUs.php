<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * @OA\Schema(
 *     title="AboutUs",
 *     description="AboutUs Model",
 * )
 */

class AboutUs extends Model
{
    //


    /**
     * @OA\Property(
     *     description="About title",
     *     title="title",
     * )
     *
     * @var string
     */
    private $title;

     /**
     * @OA\Property(
     *     description="About description",
     *     title="description",
     *     type="string",
     * )
     *
     * @var string
     */
    private $description;


    protected $fillable = [
        'title',
        'description'
    ];

    // field that should not be mass assign
    // protected $guarded = ['*'];
}
