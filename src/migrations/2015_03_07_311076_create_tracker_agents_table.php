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
        Schema::create('tracker_agents', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->mediumText('name');
            $table->string('name_hash', 65)->unique()->nullable();
            $table->string('browser')->index();
            $table->string('browser_version');

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
        Schema::dropIfExists('tracker_agents');
    }
};
