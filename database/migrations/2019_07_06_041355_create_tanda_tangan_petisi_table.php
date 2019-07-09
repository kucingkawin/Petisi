<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTandaTanganPetisiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tanda_tangan_petisi', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('petisi_id');
            $table->unsignedBigInteger('user_detail_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tanda_tangan_petisi');
    }
}
