<?php namespace Rendy\news\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateRendyNewsSlider extends Migration
{
    public function up()
    {
        Schema::create('rendy_news_slider', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name', 225);
            $table->text('description');
            $table->string('link', 225);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('rendy_news_slider');
    }
}
