<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePetisiForeignKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('petisi', function (Blueprint $table) {
            $table->foreign('user_id')->references("id")->on("users")->onDelete('cascade');
            $table->foreign('kategori_petisi_id')->references("id")->on("kategori_petisi")->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('petisi', function (Blueprint $table) {
            $table->dropForeign('petisi_user_id_foreign');
            $table->dropForeign('petisi_kategori_petisi_id_foreign');
        });
    }
}
