<?php

namespace Miniorange\Samlsp\classes\actions;

use Redirect;
use RainLab\User\Facades\Auth as Auth;
use Db;
use Flash;
use Illuminate\Support\Facades\Session as Session;
class ProcessUserAction
{
    private $attrs;
    private $relayState;
    private $sessionIndex;
    private $entries;
    private $NameID;


    /**
     * LogUserInAction constructor.
     * @param $attrs        - all the user profile attributes send by the IDP in the SAML response
     * @param $relayState   - the URL that the user needs to be redirected to
     * @param $sessionIndex - the session Index parameter provided by the IDP ( used for Single Logout Purposes )
     */
    public function __construct($attrs, $relayState, $sessionIndex,$entries,$NameID)
    {
        $this->attrs = $attrs;
        $this->relayState = $relayState;
        $this->sessionIndex = $sessionIndex;
        $this->entries = $entries;
        $this->NameID = $NameID;
    }

    function execute()
    {
        $user = Db::table('users')->where('email', $this->entries['map_email'])->first();
        if($user == NULL) {
            $password = str_random(8);
            $option =Db::table('miniorange_samlsp_saml_config')->where('id', '1')->first();
           $value=$option->user_no;
            Db::table('miniorange_samlsp_saml_config')->where('id', 1)->update([
            'user_no' => $value+1]);
            if($value<=9){$user = Auth::register([
                    'name' => isset($this->entries['map_name']) ? $this->entries['map_name'] : $this->NameID,
                    'email' => isset($this->entries['map_email']) ? $this->entries['map_email'] : $this->NameID,
                    'surname' => isset($this->entries['map_surname']) ? $this->entries['map_surname'] : $this->NameID,
                    'username' => isset($this->entries['map_username']) ? $this->entries['map_username'] : $this->NameID,
                    'password' => $password,
                    'password_confirmation' => $password
                ], true);
                //Session::put('sso_msg',$this->entries['map_email'].' user created successfully.');
                Auth::login($user);}
                else{  Session::put('sso_msg',' Please upgrade to premium for unlimited users.');}
        }
        else
        {
            $user = Auth::findUserById($user->id);
            Auth::login($user);
        }
    }

}