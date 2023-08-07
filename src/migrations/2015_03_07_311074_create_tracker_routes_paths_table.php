<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'tracker';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tracker_route_paths', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('route_id')->unsigned()->index();
            $table->foreign('route_id')->references('id')->on('tracker_routes')->onUpdate('cascade')->onDelete('cascade');
            
            $table->string('path')->index();

            $table->timestamps();
            $table->index('created_at');
            $table->index('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracker_route_paths');
    }
};
