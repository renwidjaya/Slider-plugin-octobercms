<?php

namespace Rendy\News\Components;

use Db;
use App;
use Request;
use Carbon\Carbon;
use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use Rendy\News\Models\Packages as ShowPackages;
use Rendy\News\Models\Schedules;


class Package extends ComponentBase {

    public $packages;
    public $packagesPage;
    public $keyIdentifier;
   
    public function componentDetails(){
        return [
            'name' => 'Package',
            'description' => 'Detail Package'
        ];
    }

    public function DefineProperties()
    {
        return [
            
            'packagesSlug'         => [
                'title'             => 'Package Slug',
                'description'       => 'Slug',
                'type'              => 'string',
                'default'           => '{{ :slug }}',
            ],
            
        ];
    }

    public function onRun(){

        $this->packages = $this->loadPackages();
        $this->packagesPage = $this->page['packagesPage'] = $this->property('packagesPage');
        $this->keyIdentifier = $this->property('keyIdentifier');    
        $this->page['photo'] = $this->loadPackages();
        
    }

    protected function loadPackages()
    {

        $packages = ShowPackages::with('categories', 'provinces')->where('slug',$this->property('packagesSlug'))->get();

        return $packages;
        
    }

}