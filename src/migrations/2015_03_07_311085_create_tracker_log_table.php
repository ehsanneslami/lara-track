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
        Schema::create('tracker_log', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('session_id')->unsigned()->index();
            $table->foreign('session_id')->references('id')->on('tracker_sessions')->onUpdate('cascade')->onDelete('cascade');

            $table->bigInteger('path_id')->unsigned()->nullable()->index();
            $table->foreign('path_id')->references('id')->on('tracker_paths')->onUpdate('cascade')->onDelete('cascade');

            $table->bigInteger('query_id')->unsigned()->nullable()->index();
            $table->foreign('query_id')->references('id')->on('tracker_queries')->onUpdate('cascade')->onDelete('cascade');

            $table->bigInteger('referer_id')->unsigned()->nullable()->index();
            $table->foreign('referer_id')->references('id')->on('tracker_referers')->onUpdate('cascade')->onDelete('cascade');

            $table->string('method', 10)->index();

            $table->bigInteger('route_path_id')->unsigned()->nullable()->index();
            $table->foreign('route_path_id')->references('id')->on('tracker_route_paths')->onUpdate('cascade')->onDelete('cascade');

            $table->boolean('is_ajax');
            $table->boolean('is_secure');
            $table->boolean('is_json');
            $table->boolean('wants_json');

            $table->bigInteger('error_id')->unsigned()->nullable()->index();
            $table->foreign('error_id')->references('id')->on('tracker_errors')->onUpdate('cascade')->onDelete('cascade');

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
        Schema::dropIfExists('tracker_log');
    }
};
