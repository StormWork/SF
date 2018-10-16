<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InstagramMedia extends Model
{
    
    protected $table = 'instagram_media';
    protected $primarykey = 'id';
    
    public $incrementing = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'instagram_id', 'link'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        
    ];
    
    public function instagram(){
        $this->belongsTo('App\InstagramToken', 'instagram_id');
    }
    
    public function images(){
        return $this->hasMany('App\InstagramImage', 'media_id');
    }
}
