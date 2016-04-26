<div class="card flush">
    <div class="head">
        <h1>Recently Added {{ str_plural($addonTitle) }}</h1>
    </div>
    <div class="card-body">
        <table class="control">
            @if($openTodos->count() > 0)
                @foreach($openTodos as $todo)
                    <tr>
                        <td><a href="/cp/addons/todo">{{ $todo['title'] }}</a></td>
                        <td>{{ $todo['added'] }}</td>
                        <td class="text-center"><a href="/cp/addons/todo"><span class="icon icon-eye"></span></a></td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="3">
                        No {{ strtolower(str_plural($addonTitle)) }} have been added yet... <a href="/cp/addons/todo">add some here</a>
                    </td>
                </tr>
            @endif
        </table>
    </div>
</div>

