<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function __construct()
    {
        // Admin middleware will be applied via routes
    }

    public function index()
    {
        $messages = Message::orderBy('created_at','desc')->get();
        return view('admin.messages', ['messages' => $messages]);
    }

    public function show($id)
    {
        $message = Message::findOrFail($id);
        return view('admin.message_show', ['message' => $message]);
    }

    public function create()
    {
        return view('admin.messages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        Message::create($request->only(['name', 'email', 'subject', 'content']));

        return redirect('/admin/messages')->with('status', 'Message created successfully!');
    }

    public function edit($id)
    {
        $message = Message::findOrFail($id);
        return view('admin.messages.edit', ['message' => $message]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $message = Message::findOrFail($id);
        $message->update($request->only(['name', 'email', 'subject', 'content']));

        return redirect('/admin/messages')->with('status', 'Message updated successfully!');
    }

    public function destroy($id)
    {
        $message = Message::findOrFail($id);
        $message->delete();

        return redirect('/admin/messages')->with('status', 'Message deleted successfully!');
    }
}
