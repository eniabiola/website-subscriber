<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;



/**
 * Class Website
 * @package App\Models
 * @version March 23, 2022, 6:56 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection $userWebsites
 * @property string $web_name
 * @property string $url
 */
class Website extends Model
{


    public $table = 'websites';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';




    public $fillable = [
        'web_name',
        'url'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'web_name' => 'string',
        'url' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'web_name' => 'required|string|max:255|unique:websites,web_name',
        'url' => 'required|string|max:255|unique:websites,url'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function users()
    {
        return $this->belongsToMany(\App\Models\User::class);
    }
}
