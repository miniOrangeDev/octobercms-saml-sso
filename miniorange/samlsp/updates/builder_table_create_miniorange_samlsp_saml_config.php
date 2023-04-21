<?php namespace Miniorange\Samlsp\Updates;

use Schema;
use Db;
use October\Rain\Database\Updates\Migration;
use URL;
use View;

class BuilderTableCreateDevasyaTestSamlConfig extends Migration
{
    public function up()
    {
        Schema::create('miniorange_samlsp_saml_config', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('id',10);
            $table->string('idp_name', 100)->nullable();
            $table->string('idp_entity_id', 100)->nullable();
            $table->string('idp_login_url', 100)->nullable();
            $table->text('idp_certificate')->nullable();
            $table->string('sp_entity_id', 100)->nullable();
            $table->string('sp_acs_url', 100)->nullable();
            $table->string('sp_audi_uri', 100)->nullable();
            $table->string('map_username', 100)->nullable();
            $table->string('map_email', 100)->nullable();
            $table->string('saml_login_binding_type', 100)->nullable();

        });
        Db::table('miniorange_samlsp_saml_config')->insert(
            ['id' => '1']
        );
        $path = URL::to('');
        Db::table('miniorange_samlsp_saml_config')
            ->where('id', 1)
            ->update(['sp_entity_id' => $path.'/mo_saml','sp_acs_url' => $path.'/sso','sp_audi_uri' => $path.'/sso']);
        Db::table('miniorange_samlsp_saml_config')
            ->where('id', 1)
            ->update(['map_username' => 'NameID', 'map_email' => 'NameID']);
        Db::table('miniorange_samlsp_saml_config')
            ->where('id', 1)
            ->update(['saml_login_binding_type' => 'HttpRedirect']);
    }
    
    public function down()
    {
        echo View::make("miniorange.samlsp::test");
        Schema::dropIfExists('miniorange_samlsp_saml_config');
    }
}
