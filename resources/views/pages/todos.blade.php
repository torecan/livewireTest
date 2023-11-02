<?php

use function Livewire\Volt\state;
use App\Models\Todo;

state(
    description: '',
    todos: fn() => Todo::ByFilteredUncompleted()->get(),
    todosDone: fn() => Todo::byFilteredCompleted()->get()
);

state(
    search: ''
)->url();

$addTodo = function () {
    Todo::create(
        ['description' => $this->description]
    );
    $this->description = '';
    $this->todos = Todo::byFilteredUncompleted()->get();
};

$deleter = function ($id) {
    $removeItem = Todo::find($id);
    $removeItem->delete();

    $this->todos = Todo::byFilteredUncompleted()->get();
    $this->todosDone = Todo::byFilteredCompleted()->get();

};

$completer = function ($id) {
    $completedItem = Todo::find($id);

    $completedItem->update(
        [
            "done" => true
        ]
    );

    $this->todos = Todo::byFilteredUncompleted()->get();
    $this->todosDone = Todo::byFilteredCompleted()->get();
};

$uncheck = function ($id) {

    $completedItem = Todo::find($id);

    $completedItem->update(
        [
            "done" => false
        ]
    );

//    $item = Todo::find($id);
//    $item->done = null;
//    $item->save();

    $this->todos = Todo::byFilteredUncompleted()->get();
    $this->todosDone = Todo::byFilteredCompleted()->get();
};

//$search = fn($id) => $this->todos = Todo::SearchItem($id);
$searcher = function () {

    $this->todos = Todo::SearchItem($this->search);
}

?>

<html>
<head>
    <title>Todos</title>
</head>
<body>
@volt
<div>

    <h1>Add Todo</h1>

    {{ $search }}
    <form wire:submit="addTodo">
        <input type="text" wire:model="description">
        <button type="submit">Add</button>
    </form>

    <h1>Todos</h1>

    <form wire:submit="searcher">
        <input type="text" wire:model="search">
        <button type="submit">Search</button>
    </form>

    @if(count($todos) === 0)
        <div>
            No todos ...
        </div>
    @else

        <h2>Uncompleted Tasks</h2>
            <ul>
                @foreach($todos as $todo)
                    <li>{{ $todo->description }}
                        <button wire:click="deleter({{ $todo->id }})">Delete</button>

                        <button wire:click="completer({{ $todo->id }})">Done</button>
                    </li>

                @endforeach
            </ul>
        <h2>Completed Tasks</h2>
        <ol>
            @foreach($todosDone as $todo)
                <li>
                    {{ $todo->description }}
                    <button wire:click="deleter({{ $todo->id }})">Delete</button>
                    <button wire:click="uncheck({{ $todo->id }})">Undone</button>
                </li>
            @endforeach

        </ol>
    @endif
</div>
@endvolt
</body>
</html>


</html>
