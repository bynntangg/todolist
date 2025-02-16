<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;

class TodoController extends Controller
{
    public function index()
    {
        $todos = Todo::orderBy('created_at', 'desc')->get();
        return view('todos.index', compact('todos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'prioritas' => 'required|in:Rendah,Sedang,Tinggi',
        ]);

        Todo::create($request->only('name', 'prioritas'));

        return redirect()->route('todos.index');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'prioritas' => 'required|in:Rendah,Sedang,Tinggi',
        ]);

        $todo = Todo::findOrFail($id);
        $todo->update($request->only('name', 'prioritas'));

        return redirect()->route('todos.index');
    }

    public function toggleStatus($id)
    {
        $todo = Todo::findOrFail($id);
        $todo->status = !$todo->status;
        $todo->tanggal_diceklis = $todo->status ? now() : null;
        $todo->save();

        return redirect()->route('todos.index');
    }

    public function destroy($id)
    {
        Todo::findOrFail($id)->delete();
        return redirect()->route('todos.index');
    }
}
