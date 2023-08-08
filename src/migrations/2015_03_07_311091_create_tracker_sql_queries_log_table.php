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
        Schema::create('tracker_sql_queries_log', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('log_id')->unsigned()->index();
            $table->foreign('log_id')->references('id')->on('tracker_log')->onUpdate('cascade')->onDelete('cascade');

            $table->bigInteger('sql_query_id')->unsigned()->index();
            $table->foreign('sql_query_id')->references('id')->on('tracker_sql_queries')->onUpdate('cascade')->onDelete('cascade');

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
        Schema::dropIfExists('tracker_sql_queries_log');
    }
};
