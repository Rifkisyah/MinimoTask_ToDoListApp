<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ToDoItem;
use Illuminate\Support\Facades\Auth;

class ToDoItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
 
    public function home()
    {
        $user = Auth()->user();

        if (!$user) {
            return redirect()->route('user.login')->with('error', 'You must be logged in to access this page.');
        }

        $items = ToDoItem::where('user_id', Auth::id())->get();

        return view('user.home', compact('user', 'items'));
    }

    public function addToDoList(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'to_do_content' => 'required|array|min:1',
            'to_do_content.*' => 'required|string|max:255',
        ]);
    
        ToDoItem::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'to_do_content' => implode("\n", $request->to_do_content),
        ]);

        return redirect()->route('user.home')->with('toast', 'To-Do list successfully created!');
    }
    
    public function editToDoList($id)
    {
        $todoItem = ToDoItem::findOrFail($id);
        $toDoContent = explode("\n", $todoItem->to_do_content);

        return view('user.edit-todo', compact('todoItem', 'toDoContent'));
    }

    public function updateToDoList(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'to_do_content' => 'required|array|min:1',
            'to_do_content.*' => 'required|string|max:255',
        ]);
    
        $todoItem = ToDoItem::findOrFail($id);
        $todoItem->update([
            'title' => $request->title,
            'to_do_content' => implode("\n", $request->to_do_content),
            'updated_at' => now(),
        ]);

        return redirect()->route('user.home')->with('toast', 'To-Do list successfully Updated!');
    }

    public function deleteToDo($id)
    {
        $item = ToDoItem::findOrFail($id);
        $item->delete();
    
        return redirect()->back()
            ->with('toast', 'To-Do list successfully deleted!');
    }
    

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
