<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Journal extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'story', 'image', 'prediction'
    ];

    protected $appends = ['image_url', 'tanggal'];

    public function getImageUrlAttribute () {
        if (Storage::exists($this->image)) {
            return Storage::url($this->image);
        }

        return env('APP_URL', 'http://api.test').'/images/placeholder.jpeg';
    }

    public function getTanggalAttribute () {
        return $this->created_at->format('F j, Y');
    }
}
