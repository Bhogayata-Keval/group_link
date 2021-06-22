<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'link',
        'description',
        'platform_id',
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
     * Get the platform that owns the group.
     */
    public function platform()
    {
        return $this->belongsTo(Platform::class);
    }

    /**
     * Get the tags for the group.
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
