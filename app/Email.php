<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     title="Email",
 *     description="Email Model",
 * )
 */

class Email extends Model
{
    //

   /**
     * @OA\Property(
     *     description="customer name",
     *     title="name",
     *     type="string",
     * )
     *
     * @var string
     */
    private $name;

       /**
     * @OA\Property(
     *     description="Customer email",
     *     title="email",
     *     type="string",
     * )
     *
     * @var string
     */
    private $email;

    /**
     * @OA\Property(
     *     description="Customer subject",
     *     title="subject",
     *     type="string",
     * )
     *
     * @var string
     */
    private $subject;

    /**
     * @OA\Property(
     *     description="customer message",
     *     title="body",
     *     type="string",
     * )
     *
     * @var string
     */
    private $body;


    protected $fillable = [
        'name',
        'email',
        'subject',
        'body'
    ];
}
