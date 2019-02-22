<?php

namespace Rendy\News\Components;

use Db;
use App;
use Auth;
use Request;
use Carbon\Carbon;
use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use Rendy\News\Models\Profiles as ModelProfiles;

use input;

class Profiles extends ComponentBase {

    public $profiles;

    public function componentDetails()
    {
        return [
            'name' => 'Profile',
            'description' => 'Show Agent Profile'
        ];
    }

    public function onRun()
    {
        $this->profiles = $this->loadProfiles();
    }

    protected function loadProfiles()
    {
        $user = Auth::getUser();
        $profiles = ModelProfiles::where('user_id',[$user->id])->get();
        return $profiles;
    }

}