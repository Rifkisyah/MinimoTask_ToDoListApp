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

        $item = ToDoItem::where('user_id', Auth::id())->get();

        return view('user.home', compact('user', 'item'));
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
    
        return redirect()->route('user.home')->with('success', 'ToDo item added!');
    }
    
    // public function editToDoList(Request $request, $id)
    // {
    //     $request->validate([
    //         'title' => 'required|string|max:255',
    //         'to_do_content' => 'required|array|min:1',
    //         'to_do_content.*' => 'required|string|max:255',
    //     ]);
    
    //     $todoItem = ToDoItem::findOrFail($id);
    //     $todoItem->update([
    //         'title' => $request->title,
    //         'to_do_content' => implode("\n", $request->to_do_content),
    //         'updated_at' => now(),
    //     ]);
    
    //     return redirect()->route('user.home')->with('success', 'ToDo item updated!');
    // }

    // public function deleteToDoList($id)
    // {
    //     $todoItem = ToDoItem::findOrFail($id);
    //     $todoItem->delete();

    //     return redirect()->route('user.home')->with('success', 'ToDo item deleted!');
    // }

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
