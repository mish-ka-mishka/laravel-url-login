<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUrlLoginTokensTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('url_login_tokens', function (Blueprint $table) {
            $table->id();
            $table->morphs('tokenable');
            $table->uuid('public_id')->unique();
            $table->string('token');
            $table->ipAddress('ip')->nullable();
            $table->text('user_agent')->nullable();
            $table->dateTime('expires_at')->nullable();
            $table->dateTime('consumed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('url_login_tokens');
    }
}
