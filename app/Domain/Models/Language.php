<?php

namespace App\Domain\Models;

use Illuminate\Database\Eloquent\Model;


class Language extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'code'
    ];


    public $timestamps = false;
}
