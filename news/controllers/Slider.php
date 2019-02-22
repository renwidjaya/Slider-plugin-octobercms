<?php namespace Rendy\news\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Slider extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Rendy.news', 'Rendy', 'side-menu-item3');
    }
}
