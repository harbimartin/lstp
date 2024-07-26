<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailSendsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('email_sends', function (Blueprint $table) {
            $table->id();
            $table->string('name',62);
            $table->string('receiver',62);
            $table->string('title',62);
            $table->text('body');
            $table->string('view',21);
            $table->string('error');
            $table->boolean('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('email_sends');
    }
}
