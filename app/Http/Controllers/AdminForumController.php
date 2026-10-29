<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Discussion; // Pastikan ini sesuai dengan nama Model kamu (Discussion atau Forum)

class AdminForumController extends Controller
{
    // Menampilkan daftar forum (Read)
    public function index()
    {
        // Mengambil data diskusi beserta relasi user dan balasan beserta user-nya
        $forums = Discussion::with(['user', 'replies.user'])->latest()->get();
        
        // Mengarahkan ke file view admin/forum.blade.php
        return view('admin.forum', compact('forums'));
    }

    // Menghapus pertanyaan forum (Delete)
    public function destroy($id)
    {
        $forum = Discussion::findOrFail($id);
        $forum->delete();

        return redirect()->route('admin.forum.index')->with('success', 'Pertanyaan forum berhasil dihapus!');
    }
}