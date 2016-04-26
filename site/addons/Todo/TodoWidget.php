<?php

namespace Statamic\Addons\Todo;

use Carbon\Carbon;
use Statamic\API\Folder;
use Statamic\Extend\Widget;

class TodoWidget extends Widget
{

    /**
     * The HTML that should be shown in the widget
     *
     * @return string
     */
    public function html()
    {
        $openTodos = collect(Folder::disk('storage')->getFiles('addons/Todo'))
            ->reject(function ($task) {
                $data = $this->storage->getYAML(class_basename($task));
                return $data['completed'];
            })->reverse()
            ->take($this->getConfig('limit', 1))
            ->map(function ($file) {
                $todo = $this->storage->getYAML(class_basename($file));
                $todo['added'] = Carbon::createFromTimestamp(substr(class_basename($file), 0, -5))->diffForHumans();

                return $todo;
            });

        return $this->view('widget', [
            'openTodos' => $openTodos,
            'addonTitle' => $this->getConfig('title')
        ]);
    }
}
