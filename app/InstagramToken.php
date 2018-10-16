<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InstagramToken extends Model
{
    
    protected $table = 'instagram_tokens';
    protected $primarykey = 'id';
    
    public $incrementing = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'user_id', 'token', 'name', 'username', 'profile_picture'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        
    ];
    
    public function user(){
        $this->belongsTo('App\User', 'user_id');
    }
    
    public function media(){
        return $this->hasMany('App\InstagramMedia', 'instagram_id');
    }
}
