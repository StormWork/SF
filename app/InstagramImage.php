<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InstagramImage extends Model
{
    protected $table = 'instagram_images';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     * 
     */
    protected $fillable = [
        'image_type', 'height', 'width'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'media_id'
    ];
    
    public function media(){
        $this->belongsTo('App\InstagramMedia', 'media_id');
    }
}
