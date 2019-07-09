<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTandaTanganPetisiForeignKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tanda_tangan_petisi', function (Blueprint $table) {
            $table->foreign('petisi_id')->references("id")->on("petisi")->onDelete('cascade');
            $table->foreign('user_detail_id')->references("id")->on("user_detail")->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tanda_tangan_petisi', function (Blueprint $table) {
            $table->dropForeign('tanda_tangan_petisi_petisi_id_foreign');
            $table->dropForeign('tanda_tangan_petisi_user_detail_id_foreign');
        });
    }
}
