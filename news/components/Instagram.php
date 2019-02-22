<?php

namespace Rendy\News\Components;
use Vinkla\Instagram\Instagram as Ig;
use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use Cache;

class Instagram Extends ComponentBase {

    public $items;

    public function ComponentDetails()
    {
        return [
            'name' => 'Instagram List',
            'description' => 'Instagram feed',
        ];
    }

    public function defineProperties()
    {
        return [
            'accessToken' => [
                'title'         => 'Access Token',
                'description'   => 'Instagram access token',
                'type'          => 'string',
                'default'       => '',
            ],
        ];
    }
    public function onRun()
    {
        //Check at cache first
        $items = Cache::get('ig');

        if (empty($items)) {
            $instagram = new Ig($this->property('accessToken'));
            Cache::put('ig',$instagram->media(), 20);
            $items = Cache::get('ig');
        }
        return $this->items = $items;
    }

}
?>