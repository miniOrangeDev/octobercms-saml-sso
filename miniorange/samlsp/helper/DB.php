<?php
namespace Miniorange\Samlsp\Helper;

use Illuminate\Routing\Controller;
use Illuminate\Contracts\Console\Kernel as Kernel;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Str;
use PDOException;
use phpDocumentor\Reflection\Types\Null_;
use Db as OctoberDb;

class DB extends Controller
{

    public static function get_option($table, $key)
    {
        /* 
        $option = OctoberDB::table('miniorange_samlsp_saml_config')->first()->$key;
        return $option;*/
        $option = OctoberDb::table($table)->where('id', '1')->first()->$key;
        return $option;
    }

    public static function update_option($table, $key, $value)
    {
        OctoberDB::table($table)->where('id', 1)->update([
            $key => $value
        ]);
    }

    public static function delete_option($table, $key)
    {
        OctoberDB::table($table)->where('id', 1)->update([
            $key => ''
        ]);
    }

    protected static function get_options($table)
    {
        $active_config = OctoberDB::table($table)->get()->first();
        return $active_config;
    }

    public static function get_registered_user()
    {
        $registered_user = OctoberDB::table('miniorange_samlsp_customer_details')->get()->first();
        return $registered_user;
    }

    public static function register_user($email, $password)
    {
        OctoberDB::table('mo_admin')->updateOrInsert([
            'id' => 1
        ], [
            'email' => $email,
            'password' => $password
        ]);
    }
}
?>
