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
}
