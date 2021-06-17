<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class Platform extends Model
{
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key',
        'name',
        'icon',
        'description'
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id'
    ];

    /**
     * Get the groups for the platform.
     */
    public function groups()
    {
        return $this->hasMany('App\Models\Group');
    }
}
