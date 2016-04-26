<?php

namespace Statamic\Addons\Todo;

use Illuminate\Http\Request;
use Statamic\Extend\Controller;
use Illuminate\Support\Collection;
use Statamic\Addons\Todo\Requests\AddItem;

/**
 * Class TodoController
 * @package Statamic\Addons\Todo
 */
class TodoController extends Controller
{

    /**
     * @var
     */
    private $todoRepository;

    /**
     * Replaces the __construct() method in addons
     */
    public function init()
    {
        $this->todoRepository = new TodoRepository();
    }

    /**
     * @return $this
     */
    public function index()
    {
        return $this->view('all', [
            'title' => "All " . str_plural($this->getConfig('title')),
            'addonTitle' => $this->getConfig('title')
        ]);
    }

    /**
     * @return array
     */
    public function getTodos()
    {
        return [
            'todos' => $this->todoRepository->getTodos()
        ];
    }

    /**
     * @param Request $request
     * @return array
     */
    public function markCompleted(Request $request)
    {
        $this->todoRepository->markCompleted($request->id);

        return [
            'success' => true,
            'message' => $this->getConfig('title') . ' marked as complete'
        ];
    }

    /**
     * @param AddItem $request
     * @return mixed
     */
    public function postAdd(AddItem $request)
    {
        return $this->todoRepository->saveTodo($request->title);
    }

    /**
     * @param Request $request
     * @return array
     * @throws \Exception
     */
    public function deleteTodo(Request $request)
    {
        $this->todoRepository->deleteTodo($request->id);

        return [
            'success' => true,
            'message' => $this->getConfig('title') . ' has been deleted'
        ];
    }
}
