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
        Schema::create('tracker_route_path_parameters', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('route_path_id')->unsigned()->index();
            $table->foreign('route_path_id')->references('id')->on('tracker_route_paths')->onUpdate('cascade')->onDelete('cascade');

            $table->string('parameter')->index();
            $table->string('value')->index();

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
        Schema::dropIfExists('tracker_route_path_parameters');
    }
};
