<?php namespace Miniorange\Samlsp\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;
use Db;

class BuilderTableCreateMiniorangeSamlspCustomerDetails extends Migration
{
    public function up()
    {
        Schema::create('miniorange_samlsp_customer_details', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('id');
            $table->string('cust_email', 100)->nullable();
            $table->string('cust_key', 100)->nullable();
            $table->string('cust_api_key', 100)->nullable();
            $table->string('cust_token', 100)->nullable();
            $table->string('cust_reg_status', 100)->nullable();
            $table->primary(['id']);
        });
        Db::table('miniorange_samlsp_customer_details')->insert(
            ['id' => '1']
        );
    }
    
    public function down()
    {
        Schema::dropIfExists('miniorange_samlsp_customer_details');
    }
}
