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
        Schema::create('tracker_query_arguments', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('query_id')->unsigned()->index();
            $table->foreign('query_id')->references('id')->on('tracker_queries')->onUpdate('cascade')->onDelete('cascade');

            $table->string('argument')->index();
            $table->string('value')->nullable()->index();

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
        Schema::dropIfExists('tracker_query_arguments');
    }
};
