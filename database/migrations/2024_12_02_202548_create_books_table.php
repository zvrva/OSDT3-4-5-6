<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id(); // Field for unique identifier
            $table->string('author');
            $table->string('book_title'); // Book title
            $table->integer('publication_year'); // Publication year of the book
            $table->text('information'); // Information about the book
            $table->string('cover_photo'); // Cover photo path
            $table->text('additional_information'); // Additional information
            $table->timestamps(); // Created at and updated at fields
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
}