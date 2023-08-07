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
        Schema::create('tracker_events_log', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('event_id')->unsigned()->index();
            $table->foreign('event_id')->references('id')->on('tracker_events')->onUpdate('cascade')->onDelete('cascade');

            $table->bigInteger('class_id')->unsigned()->nullable()->index();
            $table->foreign('class_id')->references('id')->on('tracker_system_classes')->onUpdate('cascade')->onDelete('cascade');

            $table->bigInteger('log_id')->unsigned()->index();
            $table->foreign('log_id')->references('id')->on('tracker_log')->onUpdate('cascade')->onDelete('cascade');

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
        Schema::dropIfExists('tracker_events_log');
    }
};
