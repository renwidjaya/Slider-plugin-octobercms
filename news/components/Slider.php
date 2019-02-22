<?php

namespace Rendy\News\Components;

use Db;
use App;
use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use Rendy\News\Models\Slider as NewsSlider;

class Slider Extends ComponentBase {

    public $slider;

    public function ComponentDetails()
    {
        return [
            'name' => 'Slider',
            'description' => 'Image Slider',
        ];
    }

    public function onRun()
    {
        $this->slider = $this->loadSlider();
    }

    public function LoadSlider()
    {
        return NewsSlider::all();

        // {{ dump($slider); }}
        
    }

}