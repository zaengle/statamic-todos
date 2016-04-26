<?php

namespace Statamic\Addons\Todo;

use Statamic\API\Nav;
use Statamic\Extend\Listener;

/**
 * Class TodoListener
 * @package Statamic\Addons\Todo
 */
class TodoListener extends Listener
{
    /**
     * The events to be listened for, and the methods to call.
     *
     * @var array
     */
    public $events = [
        'cp.nav.created' => 'addNavItems'
    ];

    /**
     * @param $nav
     */
    public function addNavItems($nav)
    {
        $todo = Nav::item(str_plural($this->getConfig('title', 'Todo')))->route('todo')->icon('list');

//        This can be used to add sub-navigation items
//        $todo->add(function($item){
//            $item->add(Nav::item('Completed')->route('todo.expired'));
//        });

        $nav->addTo('tools', $todo);
    }
}
