<?php namespace Rendy\news\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateRendyNewsSlider2 extends Migration
{
    public function up()
    {
        Schema::table('rendy_news_slider', function($table)
        {
            $table->string('service', 225);
            $table->string('client', 225);
            $table->string('agency', 225);
            $table->integer('year');
        });
    }
    
    public function down()
    {
        Schema::table('rendy_news_slider', function($table)
        {
            $table->dropColumn('service');
            $table->dropColumn('client');
            $table->dropColumn('agency');
            $table->dropColumn('year');
        });
    }
}
