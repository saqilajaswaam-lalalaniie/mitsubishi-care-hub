<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reply;
use Illuminate\Support\Facades\Auth;

class ReplyController extends Controller
{
    // Menyimpan balasan baru dari user atau admin
    public function store(Request $request, $discussionId)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        Reply::create([
            'discussion_id' => $discussionId,
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return redirect()->back()->with('success', 'Balasan berhasil dikirim!');
    }

    // Menghapus balasan (hanya pembuat atau admin)
    public function destroy($id)
    {
        $reply = Reply::findOrFail($id);

        if (Auth::id() !== $reply->user_id && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $reply->delete();

        return redirect()->back()->with('success', 'Balasan berhasil dihapus.');
    }
}