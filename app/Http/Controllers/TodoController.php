<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;

class TodoController extends Controller
{
    public function index()
    {
        $todos = Todo::orderBy('prioritas', 'desc')->get();
        return view('todos.index', compact('todos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'prioritas' => 'required|integer|min:1|max:5',
        ]);

        Todo::create([
            'name' => $request->name,
            'prioritas' => $request->prioritas,
            'status' => false,
        ]);

        return redirect()->route('todos.index');
    }

    public function update(Request $request, Todo $todo)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'prioritas' => 'required|integer|min:1|max:5',
        ]);

        $todo->update([
            'name' => $request->name,
            'prioritas' => $request->prioritas,
        ]);

        return redirect()->route('todos.index');
    }

    public function toggleStatus(Todo $todo)
    {
        $newStatus = !$todo->status;
        $todo->update([
            'status' => $newStatus,
            'tanggal_diceklis' => $newStatus ? now() : null,
        ]);

        return redirect()->route('todos.index');
    }

    public function destroy(Todo $todo)
    {
        $todo->delete();
        return redirect()->route('todos.index');
    }
}
