<?php

namespace Rendy\News\Components;

use Db;
use App;
use Request;
use Carbon\Carbon;
use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use Rendy\News\Models\Provinces as NewsProvinces;

class Provinces Extends ComponentBase {

    public $provinces;
    public $provincesPage;
    public $keyIdentifier;

    public function ComponentDetails()
    {
        return [
            'name' => 'Provinces',
            'description' => 'List Provinces',
        ];
    }

    public function defineProperties()
    {
        return [
            'keyIdentifier' => [
                'title'         => 'Key Identifier',
                'description'   => 'key Identifier',
                'type'          => 'string',
                'default'       => 'slug',
            ],
            'province'      => [
                'title'     => 'Single Province',
                'description' => 'Single Province',
                'type'      => 'string',
                'default'   => '{{:province}}'
            ],
            'provincesPage' => [
                'title'         => 'provinces Page',
                'description'   => 'provinces Page',
                'type'          => 'dropdown',
                'default'       => 'sub/provinces',
                'group'         => 'Links',
            ]
        ];
    }

    public function onRun()
    {
        $this->provinces = $this->loadProvinces();
        $this->provincesPage = $this->page['provincesPage'] = $this->property('provincesPage');
        $this->keyIdentifier = $this->property('KeyIdentifier');
    }
    
    public function getProvincesPageOptions()
    {
        return page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    public function loadProvinces()
    {
        if($this->property('province') != "" || !empty($this->property('province'))){
            return NewsProvinces::where('slug',$this->property('province'))->first();
        } else {
            return NewsProvinces::all();
        }    
    }
}