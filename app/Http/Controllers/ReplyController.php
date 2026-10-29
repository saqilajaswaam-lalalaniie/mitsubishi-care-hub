<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reply; // Pastikan Model Reply sudah ada

class ReplyController extends Controller
{
    public function store(Request $request, $discussionId)
    {
        // Validasi input balasan dari admin
        $request->validate([
            'reply' => 'required|string|max:1000',
        ]);

        // Simpan balasan ke dalam database
        Reply::create([
            'discussion_id' => $discussionId,
            'user_id' => auth()->id(), // Menyimpan ID admin yang sedang login
            'content' => $request->reply,
        ]);

        // Kembalikan ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Solusi berhasil dikirim ke pengguna!');
    }
}