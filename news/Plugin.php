<?php namespace Rendy\news;

use System\Classes\PluginBase;
use app;
use Illuminate\Foundation\AliasLoader;
use RainLab\User\Models\User as UserModel;
use RainLab\User\Controllers\Users as UsersController;
use Rendy\News\Models\Slider;


class Plugin extends PluginBase
{
    public $require = ['Rainlab.User'];

    public function PluginDetails()
    {
        return [
            'name' => 'Product',
            'description' => 'Management Product',
            'author' => 'Rendy',
            'icon' => 'icon-archive',
        ];
    }

    public function registerComponents()
    {
        return  [ 
            'Rendy\News\Components\Instagram' => 'instagram',
            'Rendy\News\Components\Slider' => 'slider',
        ];
    }

    public function registerSettings()
    {
    }

    public function boot()
    {
        //search plugin
        \Event::listen('offline.sitesearch.query', function ($query) {
        
        //search your plugin's contents
        $item = Packages::where('name', 'like', "%${query}%")
                                ->orWhere('overview', 'like', "%${query}%")
                                ->get();

        //now build a results array
        $results = $item->map(function ($item) use ($query) {
            // if the query is found in the title, set a relevance  of 2
            $relevance = mb_stripos($item->name, $query) !== false ? 2 : 1;

            return [
                'title'     => $item->name,
                'text'      => $item->overview,
                'url'       => '/packages/' . $item->slug,
                'thumb'     => $item->photo,
                'relevance' => $relevance,
            ];
        });

            return [
                'provider'  => 'Document',
                'results'   => $results,
            ];
        
        });
    }
}
