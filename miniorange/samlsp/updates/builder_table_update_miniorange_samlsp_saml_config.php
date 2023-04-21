<?php namespace Miniorange\Samlsp\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateMiniorangeSamlspSamlConfig extends Migration
{
    public function up()
    {
        Schema::table('miniorange_samlsp_saml_config', function($table)
        {
            $table->integer('user_no')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('miniorange_samlsp_saml_config', function($table)
        {
            $table->dropColumn('user_no');
        });
    }
}
