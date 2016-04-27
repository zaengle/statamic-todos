<?php

namespace Statamic\Addons\Todo;

use Statamic\Extend\Tags;

class TodoTags extends Tags
{

    public function showOpen()
    {
        $todoRepository = new TodoRepository();

        $todos = $todoRepository->getOpenTodos();

        return $this->parseLoop(
            $todos->map(function ($todo) {
                return [
                    'todo_title' => $todo['title'],
                    'todo_added' => $todo['added']
                ];
            })
        );
    }
}
