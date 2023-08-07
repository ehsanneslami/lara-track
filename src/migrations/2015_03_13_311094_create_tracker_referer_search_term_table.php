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
        Schema::create('tracker_referers_search_terms', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('referer_id')->unsigned()->index();
            $table->foreign('referer_id')->references('id')->on('tracker_referers')->onUpdate('cascade')->onDelete('cascade');

            $table->string('search_term')->index();

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
        Schema::dropIfExists('tracker_referers_search_terms');
    }
};
