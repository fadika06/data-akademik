<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDataAkademiksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
	public function up()
	{
		Schema::create('data_akademiks', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
			$table->string('nomor_un');
			$table->string('nama_siswa');
            $table->decimal('bahasa_indonesia')->nullable();
            $table->decimal('bahasa_inggris')->nullable();
            $table->decimal('matematika')->nullable();
            $table->decimal('ipa')->nullable();
			$table->timestamps();
			$table->softDeletes();
        });
	}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
	public function down()
	{
		Schema::drop('data_akademiks');
	}
}
