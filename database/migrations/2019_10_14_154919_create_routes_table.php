<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('routes', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->string('url', 500)->unique()->index();
            $table->nullableMorphs('routable');
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
     */
    public function down(): void
    {
        Schema::dropIfExists('routes');
    }
};
