<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Psychologist extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'image', 'gmap'
    ];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute () {
        if (Storage::exists($this->image)) {
            return Storage::url($this->image);
        }

        return env('APP_URL', 'http://api.test').'/images/placeholder.jpeg';
    }
}
