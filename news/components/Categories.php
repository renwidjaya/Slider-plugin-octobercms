<?php

namespace Rendy\News\Components;

use Db;
use App;
use Request;
use Carbon\Carbon;
use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use Rendy\News\Models\Categories as ListCategories;

class Categories Extends ComponentBase {

    public $categories;
    public $categoriesPage;
    public $keyIdentifier;

    public function ComponentDetails()
    {
        return [
            'name' => 'Categories',
            'description' => 'List Categories',
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
            'category'      => [
                'title'         => 'Category',
                'description'   => 'Get single Category by slug',
                'type'          => 'string',
                'default'       => '{{ :categories }}',
            ],
            'categoriesPage' => [
                'title'         => 'Category Page',
                'description'   => 'Category Page',
                'type'          => 'dropdown',
                'default'       => 'sub/categories',
                'group'         => 'Links',
            ]
        ];
    }

    public function onRun()
    {
        $this->categories = $this->loadCategories();
        $this->categoriesPage = $this->page['categoriesPage'] = $this->property('categoriesPage');
        $this->keyIdentifier = $this->property('KeyIdentifier');
    }
    
    public function getCategoriesPageOptions()
    {
        return page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    public function loadCategories()
    {
        if($this->property('category') != "" || !empty($this->property('category'))){
            $categories = ListCategories::where('slug',$this->property('category'))->first();
        } else {
            $categories = ListCategories::all();
        }    
        
        return $categories;
    }
}
