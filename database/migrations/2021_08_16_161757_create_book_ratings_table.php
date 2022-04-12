<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_ratings', function (Blueprint $table) {
            $table->id();
            $table->integer('book_id');
            $table->integer('user_id')->comment = 'pk of users.id';
            $table->integer('rating');
            $table->timestamps();
            $table->softDeletes();
            $table->tinyInteger('valid')->default->comment = '1=Yes, 0=No';

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('book_ratings');
    }
}
