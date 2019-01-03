<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIcommercecheckmoIcommerceCheckmoTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('icommercecheckmo__icommercecheckmo_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields

            $table->integer('icommercecheckmo_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['icommercecheckmo_id', 'locale']);
            $table->foreign('icommercecheckmo_id')->references('id')->on('icommercecheckmo__icommercecheckmos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('icommercecheckmo__icommercecheckmo_translations', function (Blueprint $table) {
            $table->dropForeign(['icommercecheckmo_id']);
        });
        Schema::dropIfExists('icommercecheckmo__icommercecheckmo_translations');
    }
}
