<?php namespace Rendy\news\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateRendyNewsSlider extends Migration
{
    public function up()
    {
        Schema::table('rendy_news_slider', function($table)
        {
            $table->integer('active')->default(1);
        });
    }
    
    public function down()
    {
        Schema::table('rendy_news_slider', function($table)
        {
            $table->dropColumn('active');
        });
    }
}
