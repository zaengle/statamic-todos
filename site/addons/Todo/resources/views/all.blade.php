@extends('layout')

@section('content')

    <todos inline-template v-cloak
        get="{{ route('todo.getAll') }}"
        complete="{{ route('todo.complete') }}"
        add="{{ route('todo.postAdd') }}"
        delete="{{ route('todo.delete') }}"
    >
        <div class="card">
            <div class="head">
                <h1>Open {{ str_plural($addonTitle) }}</h1>
                <div class="pull-right">
                    <form @submit.prevent="addTodo">
                        <input type="text" class="form-control-sm" placeholder="Add a new {{ strtolower($addonTitle) }}..." v-model="newTodo.title">
                    </form>
                </div>
            </div>
            <table>
                <thead>
                <tr>
                    <th v-if="hasOpenTodos"></th>
                    <th>Items</th>
                    <th>Added</th>
                </tr>
                </thead>
                <tbody>
                    <tr class="no-border" v-for="todo in allTodos | orderBy 'id' -1" v-if="! todo.completed">
                        <td class="checkbox-col">
                            <input type="checkbox" id="@{{ todo.id }}" @click="completeTodo(todo)">
                            <label for="@{{ todo.id }}"></label>
                        </td>
                        <td>
                            @{{ todo.title }}
                        </td>
                        <td>
                            @{{ todo.added }}
                        </td>
                    </tr>

                    <tr v-if="! hasOpenTodos" v-cloak >
                        <td colspan="32">
                            <em>No Open {{ str_plural($addonTitle) }}!</em>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="card" v-if="hasCompletedTodos">
            <div class="head">
                <h1>Completed {{ str_plural($addonTitle) }}</h1>
            </div>
            <table>
                <thead>
                <tr>
                    <th>Items</th>
                    <th>Completed</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr class="no-border" v-for="todo in allTodos | orderBy 'id' -1" v-if="todo.completed">
                    <td>
                        <strike>@{{ todo.title }}</strike>
                    </td>
                    <td>
                        @{{ todo.completedAt }}
                    </td>
                    <td class="pull-right">
                        <a href="#" @click.prevent="trashTodo(todo)">
                            <i class="icon icon-trash"></i>
                        </a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </todos>
@endsection