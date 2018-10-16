<?php

namespace App;

class InstagramApi{
    
    private $instagram;
    
    public function __construct($clientId, $clientSecret, $redirectUrl){
        $this->instagram = new \MetzWeb\Instagram\Instagram(array(
            'apiKey' => $clientId,
            'apiSecret' =>  $clientSecret,
            'apiCallback'   =>  $redirectUrl
        ));        
    }
    
    /*
    response: {access_token: "8714313927.ef4da18.ade19ecfee1b474fb546173ec5a4b6aa",…}
    access_token: "8714313927.ef4da18.ade19ecfee1b474fb546173ec5a4b6aa"
    user: {id: "8714313927", username: "tiro589",…}
    bio: ""
    full_name: "T Smith"
    id: "8714313927"
    is_business: false
    profile_picture: "https://scontent-frx5-1.cdninstagram.com/vp/a8539c22ed9fec8e1c43b538b1ebfd1d/5C5A1A7A/t51.2885-19/11906329_960233084022564_1448528159_a.jpg"
    username: "tiro589"
    website: ""
     */
    
    function getOAuth($code){
        return $this->instagram->getOAuthToken($code);
    }
    
    function setAccessToken($auth){
        $this->instagram->setAccessToken($auth);
    }
    
    function getUserMedia(){
        return $this->instagram->getUserMedia('self');
    }
    
    function getUserMediaLimits(){
        return $this->instagram->getUserMedia('self', array(
            //'max_id' => '',
            //'min_id' => '',
            'count' => '100'
        ));
    }
}