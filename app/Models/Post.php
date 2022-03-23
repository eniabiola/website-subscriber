<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;



/**
 * Class Post
 * @package App\Models
 * @version March 23, 2022, 7:34 pm UTC
 *
 * @property \App\Models\Website $website
 * @property string $title
 * @property string $description
 * @property string $body
 * @property integer $website_id
 */
class Post extends Model
{


    public $table = 'posts';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';




    public $fillable = [
        'title',
        'description',
        'body',
        'website_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'title' => 'string',
        'description' => 'string',
        'body' => 'string',
        'website_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title' => 'required|string|max:255|unique:posts,title',
        'description' => 'required|string|max:255',
        'body' => 'required|string|max:255',
        'website_id' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function website()
    {
        return $this->belongsTo(\App\Models\Website::class, 'website_id');
    }
}
