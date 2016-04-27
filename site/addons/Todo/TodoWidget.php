<?php

namespace Statamic\Addons\Todo;

use Carbon\Carbon;
use Statamic\Extend\Widget;

class TodoWidget extends Widget
{

    private $todoRepository;

    public function init()
    {
        $this->todoRepository = new TodoRepository();
    }

    public function html()
    {
        return $this->view('widget', [
            'openTodos'  => $this->todoRepository->getOpenTodos($this->getConfig('limit', 5)),
            'addonTitle' => $this->getConfig('title')
        ]);
    }
}
