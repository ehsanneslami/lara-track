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
        Schema::create('tracker_referers', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('domain_id')->unsigned()->index();
            $table->foreign('domain_id')->references('id')->on('tracker_domains')->onUpdate('cascade')->onDelete('cascade');

            $table->string('url')->index();
            $table->string('host');
            $table->string('medium')->nullable()->index();
            $table->string('source')->nullable()->index();
            $table->string('search_terms_hash')->nullable()->index();
            
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
        Schema::dropIfExists('tracker_referers');
    }
};
