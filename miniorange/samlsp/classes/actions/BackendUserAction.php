<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 07-05-2019
 * Time: 16:09
 */

namespace Miniorange\Samlsp\classes\actions;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Db as Db;
use Miniorange\Samlsp\Helper\PluginSettings;
use October\Rain\Auth\AuthException;
use Redirect;
use BackendAuth;
use Backend as Backend;
use Session;

class BackendUserAction
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
        $user = Db::table('backend_users')->where('email', $this->entries['map_email'])->first();
        if($user == NULL) {
            Session::put('sso_msg',$this->entries['map_email'].' not found. Please check your registered email or contact an administrator.');
            return Redirect::to(Backend::url(''));
        }
        else
        {
            $user = BackendAuth::findUserById($user->id);
            BackendAuth::login($user);
            return Redirect::to(Backend::url(''));
        }
    }
   /* function execute()
    {
      //$pluginSettings = PluginSettings::getPluginSettings();
        $user = Db::table('backend_users')->where('email', $this->entries['map_email'])->first();
        if($user == NULL) {
            //Session::put('sso_msg',$this->entries['map_email'].' not found. Please check your registered email or contact an administrator.');
            //Session::put('sso_msg'.' new user will be created.');
            Session::put('sso_msg',$this->entries['map_email'].' not found. new user will be created.');
//$ new_user=Db: table('backend_users')
           $option =Db::table('miniorange_samlsp_saml_config')->where('id', '1')->first();
           $value=$option->user_no;
            // $option = Db::table('miniorange_samlsp_saml_config')->where('id', '1')->value('user_no');
            //$option=$pluginSettings->getUserno();
if( $value <=9)
{   
          //Db::update('update miniorange_samlsp_saml_config set user_no = ?',($value+1));
           Db::table('miniorange_samlsp_saml_config')->where('id', 1)->update([
            'user_no' => $value+1
        ]);
            $new_email=$this->entries['map_email'];
            $new_login=$this->entries['map_email'];
            $user = strstr($new_login, '@', true);
            //$new_login = explode('@', $new_login)[1];
            //$username_idp=
              $samlResponseObj = ReadResponseAction::execute(); // read the samlResponse from IDP
                $responseAction = new ProcessResponseAction($samlResponseObj);
                $responseAction->execute();
                $username_idp = current(current($samlResponseObj->getAssertions())->getNameId());
            $new_password=$username_idp;
             $new_password=Hash::make($new_password);
            $data=array('login'=>$new_login,"email"=>$new_email,"password"=>$new_password);
DB::table('backend_users')->insert($data);
      Session::put('sso_msg',$this->entries['map_email'].' user created successfully.');
      //sleep(5);
//echo "Domain name is :" . $domain_name;
      $created_user = Db::table('backend_users')->where('email', $this->entries['map_email'])->first();
       $created_user = BackendAuth::findUserById($created_user->id);
      BackendAuth::login($created_user);
            return Redirect::to(Backend::url(''));
}
else{
  Session::put('sso_msg',$this->entries['map_email'].'free trial expired.Please upgrade to premium');
   return Redirect::to(Backend::url(''));
}
        }
        else
        {
            $user = BackendAuth::findUserById($user->id);
      BackendAuth::login($user);
    return Redirect::to(Backend::url(''));
    
        }
    }*/
}