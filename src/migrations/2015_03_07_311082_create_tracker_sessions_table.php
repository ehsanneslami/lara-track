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
        Schema::create('tracker_sessions', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('uuid')->unique()->index();
            $table->bigInteger('user_id')->unsigned()->nullable()->index();

            $table->bigInteger('device_id')->unsigned()->nullable()->index();
            $table->foreign('device_id')->references('id')->on('tracker_devices')->onUpdate('cascade')->onDelete('cascade');

            $table->bigInteger('agent_id')->unsigned()->nullable()->index();
            $table->foreign('agent_id')->references('id')->on('tracker_agents')->onUpdate('cascade')->onDelete('cascade');

            $table->string('client_ip')->index();
            $table->bigInteger('referer_id')->unsigned()->nullable()->index();
            $table->foreign('referer_id')->references('id')->on('tracker_referers')->onUpdate('cascade')->onDelete('cascade');

            $table->bigInteger('cookie_id')->unsigned()->nullable()->index();
            $table->foreign('cookie_id')->references('id')->on('tracker_cookies')->onUpdate('cascade')->onDelete('cascade');

            $table->bigInteger('geoip_id')->unsigned()->nullable()->index();
            $table->foreign('geoip_id')->references('id')->on('tracker_geoip')->onUpdate('cascade')->onDelete('cascade');

            $table->bigInteger('language_id')->unsigned()->nullable()->index();
            $table->foreign('language_id')->references('id')->on('tracker_languages')->onUpdate('cascade')->onDelete('cascade');
            
            $table->boolean('is_robot');

    
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
        Schema::dropIfExists('tracker_sessions');
    }
};
