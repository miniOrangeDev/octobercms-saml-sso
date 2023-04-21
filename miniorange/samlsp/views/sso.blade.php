<?php use URL as URL;
use October\Rain\Auth\AuthException as AuthException;
use Illuminate\Support\Facades\Session as Session;
use October\Rain\Support\Facades\Flash as Flash;
use Miniorange\Samlsp\Helper\Utilities as Utilities;


if (Session::has('sso_msg')) {
    $msg = Session::get('sso_msg');
    Flash::error($msg);
    Session::pull('sso_msg');
}
?>
<div style="display:inline-block;float:right">
<?php 
if(!Utilities::isSPConfigured())
{
    //Flash::error('No Idp configured. Please contact your administrator.');}
    }else
    {
    	echo "<button class=\"btn btn-primary\"onclick=\"backend_sso()\">Single Sign On</button>";
    }
 
?>
</div>
<script type="application/javascript">
    function backend_sso(){
        window.location.replace('<?php echo URL::to('saml_redirect?RelayState=backendauth');?>');
    }
</script>

