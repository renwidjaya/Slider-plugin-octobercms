<?php

namespace Rendy\News\Components;

use Db;
use App;
use Request;
use Carbon\Carbon;
use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use Rendy\News\Models\Packages as ShowPackages;
use Rendy\News\Models\Provinces;
use Rendy\News\Models\Categories;
use Rendy\News\Models\Schedules;
use Input;

class Packages extends ComponentBase {

    public $packages;
    public $packagesPage;
    public $keyIdentifier;
    public $packagesPerPage;
    public $categoriesFilter;
    public $provincesFilter;
    public $currentPackages;
    public $sorting = '';

    public function componentDetails(){
        return [
            'name' => 'Packages',
            'description' => 'Display List'
        ];
    }

    public function DefineProperties()
    {
        return [
            'packagesPerPage'  => [
                'title'             => 'Packages Per Pages',
                'description'       => 'List of Packages per page',
                'type'              => 'string',
                'validationPattern' => '^[0-9]+$',
                'validationMessage' => 'Number Only',
                'default'           => '10',
            ],
            'keyIdentifier'         => [
                'title'             => 'Key Identifier',
                'description'       => 'Key Identifier',
                'type'              => 'string',
                'default'           => 'slug',
            ],
            'categoriesFilter' => [
                'title'             => 'Category Filter',
                'description'       => 'Filter category by category name/slug',
                'stype'             => 'string|filter',
                'default'           => '{{ :categories }}',
            ],
            'provincesFilter'  => [
                'title'             => 'Provinces Filter',
                'description'       => 'Filter provinces by name/slug',
                'type'              => 'string',
                'default'           => '{{ :provinces }}',
            ],
            'currentPackages'  => [
                'title'             => 'Current Packages',
                'description'       => 'Current packages slug',
                'type'              => 'string',
                'default'           => '{{ :slug }}',
            ],
            'packagesPage'     => [
                'title'             => 'Packages Page',
                'description'       => 'Packages Page',
                'type'              => 'dropdown',
                'default'           => 'packages',
                'group'             => 'link',
            ],
        ];
    }
    public function onRun()
    {
        $this->sorting = Input::get('sorting');
        $this->packages = $this->loadPackages();
        $this->packagesPage = $this->page['packagesPage'] = $this->property('packagesPage');
        $this->keyIdentifier = $this->property('keyIdentifier');
        $this->categoriesFilter = $this->property('categoriesFilter');
        $this->provincesFilter = $this->property('provincesFilter');
        $this->currentPackages = $this->property('currentPackages');
    }

    public function getPackagesPageOptions()
    {
        return page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    public function getCategoriesPageOptions()
    {
        return page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    protected function loadPackages(){

        $query = ShowPackages::with('categories', 'provinces');

        if($this->property('provincesFilter') != "" || !empty($this->property('provincesFilter'))){
            $provinces = Provinces::where('slug', $this->property('provincesFilter'))->first();
            $query = $query->where('provinces_id', $provinces->id);
        }   

        if($this->property('categoriesFilter') != "" || !empty($this->property('categoriesFilter'))){
            $categories = Categories::where('slug', $this->property('categoriesFilter'))->first();
            $query = $query->where('categories_id', $categories->id);
        }

        $packages = $query->paginate($this->property('packagesPerPage'));
        
        if ($this->sorting !='') {
            $sort = explode("-", $this->sorting);
            if($sort[0] == 'price'){
                $query->join('Rendy_news_schedules', 'Rendy_news_packages.id','=','Rendy_news_schedules.id')->orderBy('price_after_discount', $sort[1]);
            }else{
                $query = $query->orderBy($sort[0],$sort[1]);
            }
        }

        $keyIdentifier = $this->property('keyIdentifier');
        
        foreach ($packages as $key => $value) {
            $packages[$key]['key_identifier'] = $packages[$key][$keyIdentifier];
        }

        return $packages;

    }

}