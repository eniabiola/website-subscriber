<?php

namespace App\Repositories;

use App\Models\Website;
use App\Repositories\BaseRepository;

/**
 * Class WebsiteRepository
 * @package App\Repositories
 * @version March 23, 2022, 6:56 pm UTC
*/

class WebsiteRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'web_name',
        'url'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Website::class;
    }
}
