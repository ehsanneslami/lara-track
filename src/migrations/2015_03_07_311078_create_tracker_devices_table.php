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
        Schema::create('tracker_devices', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('kind', 16)->index();
            $table->string('model', 64)->index();
            $table->string('platform', 64)->index();
            $table->string('platform_version', 16)->index();
            $table->boolean('is_mobile');

            $table->unique(['kind', 'model', 'platform', 'platform_version']);

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
        Schema::dropIfExists('tracker_devices');
    }
};
