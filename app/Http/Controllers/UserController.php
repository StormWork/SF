<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

use Laravel\Socialite\Facades\Socialite;

use App\User;
use App\InstagramToken;

use MetzWeb\Instagram\Instagram;
use App\InstagramApi;


class UserController extends Controller
{
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    
    public function getUserProfile(Request $request){
        if($request->user){
            
            $user = User::findOrFail(3);
            $instagram = $user->instagramtoken;
            
            if($instagram != null){
                
                $media = $instagram->media;
                
                $entries = array();
                
                foreach($media as $entry){
                    $images = array();
                    
                    foreach($entry->images as $image){
                        $images[$image->image_type] = array(
                            'url' => $image->link,
                            'width' => $image->width,
                            'height' => $image->height,
                            'type' => $image->image_type
                        );
                    }
                    
                    $entries[$entry->id] = array(
                        'url' => $entry->link,
                        'images' => $images
                    );
                }
                
                $response = array(
                    'name' => $instagram->name,
                    'username' => $instagram->username,
                    'profile_picture' => $instagram->profile_picture,
                    'media' => $entries
                );
                
                
                return response()->json($response, 200);
            }
            
        }
        
        return response()->json(['error' => $user], 201);
    }
    
    public function loginUser(Request $request){
        if($request->code){
            $auth = app(InstagramApi::class)->getOAuth($request->code);
            $token = $auth->access_token;
            
            //Set the token for use
            app(InstagramApi::class)->setAccessToken($token);
            
            $user = $auth->user;
            $name = $user->full_name;
            $id = $user->id;
            $profilePicture = $user->profile_picture;
            $username = $user->username;
            
            $tokenEntry = null;
            $userEntry = null;
            
            try{
                //Check if the Instagram user is already created
                $tokenEntry = InstagramToken::findOrFail($id)->first();
                
                $tokenEntry->profile_picture = $profilePicture;
                $tokenEntry->name = $name;
                $tokenEntry->username = $username;
                $tokenEntry->token = $token;
                
                $tokenEntry->save();
                                
                
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
                // Need to create a user and the token for this user
                // TODO: Potentially remove the need to create a user for instagram users
                
                $userEntry = User::create([
                   'user_type' => 1,
                ]);
                
                $tokenEntry = new InstagramToken([
                    'id' => $id,
                    'profile_picture' => $profilePicture,
                    'name' => $name,
                    'username' => $username,
                    'token' => $token
                ]);
                
                $userEntry->instagramtoken()->save($tokenEntry);
                
                // Update user row to have Instagram ID, as a pre-caution
                $userEntry->instagram_id = $tokenEntry->id;
                $userEntry->save();
            }
            
            // Media grabbing code, TODO: Move this to it's own function and remove from registration process
            $userMedia = app(InstagramApi::class)->getUserMediaLimits();
            
            foreach($userMedia->data as &$media){
                if($media->type == 'image'){
                    $count = \App\InstagramMedia::where('id', '=', $media->id)->count();
                    if($count == 0){                    
                        // Double check we've got an image
                        $mediaEntry = new \App\InstagramMedia([
                            'id' => $media->id,
                            'link' => $media->link
                        ]);

                        foreach($media->images as $key => $val){
                            // Loop through all images for this media
                            $image = new \App\InstagramImage([
                               'image_type' => $key,
                               'width' => $val->width,
                               'height' => $val->height,
                               'link' => $val->url
                            ]);

                            $mediaEntry->images()->save($image);
                        }

                        $tokenEntry->media()->save($mediaEntry);
                    }
                }
            }
            
            
            return response()->json(['logged' => true], 200);
        }
        
        return response()->json(['logged' => false], 200);
    }
	
    public function showPhotos(Request $request){
	return response()->json('Nothing', 201);
    }
    
    public function getMe(){
        return response()->json('??', 200);
    }
    
    
    
    public function createUser(Request $request){
        /*$rules = [
          'email' => 'required|email|unique:users',
          'password' => 'required|min:5'
        ];
        
        $this->validate($request, $rules);
        
        $user = User::create([
           'email' => $request->email,
           'password' => password_hash($request->password, PASSWORD_BCRYPT)
        ]);
        
        $auth = $user->createToken(null);*/
        
        $token =  new InstagramToken([
            'token' => 't90ru9i0opgdmkf'
        ]);
        
        $userObj = User::find(19);
        $userObj->instagramToken()->save($token);
        
        return $auth;
        
        //return response()->json(['data' => "User ".$user->id, 'password' => Hash::make($request->password), 'passwordplain' => $request->password], 201);
    }
    
    public function getFacebookURI(){
        return Socialite::driver('facebook')->stateless()->redirect();
    }
    
    public function facebookCallback(){
        try{
            $providerUser = Socialite::driver('facebook')->stateless()->user();
            return response()->json($providerUser);
        }catch(\GuzzleHttp\Exception\ClientException $e){
            //Token expired most likely
            return response()->json(['exception']);
        }
        
    }

}
