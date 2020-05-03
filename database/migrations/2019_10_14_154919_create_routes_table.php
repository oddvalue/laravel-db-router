<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('routes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('url', 500)->unique()->index();
            $table->nullableMorphs('routeable');
            $table->string('controller')->nullable();
            $table->string('action')->nullable();
            $table->unsignedInteger('canonical_id')->nullable()
                ->references('id')->on('routes');
            $table->unsignedInteger('redirect_id')->nullable()
                ->references('id')->on('routes')->onDelete('cascade');
            $table->softDeletes();
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
        Schema::dropIfExists('routes');
    }
}
