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
        Schema::create('tracker_sql_query_bindings_parameters', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('sql_query_bindings_id')->unsigned()->nullable();
            $table->foreign('sql_query_bindings_id', 'tracker_sqlqb_parameters')->references('id')->on('tracker_sql_query_bindings')->onUpdate('cascade')->onDelete('cascade');
            
            $table->string('name')->nullable()->index();
            $table->text('value')->nullable();

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
        Schema::dropIfExists('tracker_sql_bindings_parameters');
    }
};
