<?php

namespace Statamic\Addons\Todo;

use Carbon\Carbon;
use Statamic\API\File;
use Statamic\API\Folder;
use Statamic\API\Storage;
use Statamic\Extend\Addon;
use Illuminate\Support\Collection;

/**
 * Class TodoRepository
 * @package Statamic\Addons\Todo
 */
class TodoRepository extends Addon
{

    /**
     * @var Collection
     */
    private $todos;

    /**
     * TodoRepository constructor.
     */
    public function __construct()
    {
        $this->todos = new Collection;
    }

    /**
     * Retrieve all Todos and parse them
     * @return mixed
     */
    public function getTodos($status = null, $limit = 100)
    {
        return collect(Folder::disk('storage')->getFiles('addons/Todo'))
            ->reverse()
            ->map(function ($file) {
                return $this->prepTodo($file);
            });
    }

    /**
     * @param int $limit
     * @return mixed
     */
    public function getOpenTodos($limit = 100)
    {
        return collect(Folder::disk('storage')->getFiles('addons/Todo'))
            ->reverse()
            ->reject(function ($file) {
                $todo = Storage::getYAML($file);

                return $todo['completed'];
            })->take($limit)
            ->map(function ($file) {
                return $this->prepTodo($file);
            });
    }
    
    /**
     * Save a single Todo
     * @param $title
     * @return mixed
     */
    public function saveTodo($title)
    {
        $timestamp = Carbon::now()->timestamp;

        Storage::putYAML('addons/Todo/' . $timestamp, [
            'title'     => $title,
            'completed' => false
        ]);

        return $this->prepTodo('addons/Todo/' . $timestamp . '.yaml');
    }

    /**
     * @param $todoId
     */
    public function markCompleted($todoId)
    {
        $file = Storage::getYAML('addons/Todo/' . $todoId . '.yaml');
        $file['completed'] = true;
        $file['completedAt'] = Carbon::now()->timestamp;
        Storage::putYAML('addons/Todo/' . $todoId . '.yaml', $file);
    }

    /**
     * @param $todoId
     * @return mixed
     * @throws \Exception
     */
    public function deleteTodo($todoId)
    {
        return File::disk('storage')->delete('addons/Todo/' . $todoId . '.yaml');
    }

    /**
     * Add in some computed values
     * @param $file
     * @return mixed
     */
    private function prepTodo($file)
    {
        $todo = Storage::getYAML($file);
        $todo['added'] = Carbon::createFromTimestamp($this->stripYAMLExtension($file))->diffForHumans();
        $todo['id'] = $this->stripYAMLExtension($file);
        $todo['completedAt'] = isset($todo['completedAt']) ? Carbon::createFromTimestamp($todo['completedAt'])->diffForHumans() : null;

        return $todo;
    }

    /**
     * @param $file
     * @return mixed
     */
    private function stripYAMLExtension($file)
    {
        if (substr(strtolower($file), -5) !== '.yaml') {
            return $file;
        }

        return substr(class_basename($file), 0, -5);
    }

}