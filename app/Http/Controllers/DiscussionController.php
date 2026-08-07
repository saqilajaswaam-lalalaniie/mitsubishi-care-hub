<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Discussion;
use Illuminate\Support\Facades\Auth;

class DiscussionController extends Controller
{
    // Read: Menampilkan daftar forum QnA
    public function index(Request $request)
    {
        $search = $request->input('search');
        $category = $request->input('category');

        $discussions = Discussion::with('user')
            ->when($search, function($query, $search) {
                return $query->where('title', 'like', "%{$search}%")
                             ->orWhere('content', 'like', "%{$search}%");
            })
            ->when($category, function($query, $category) {
                return $query->where('category', $category);
            })
            ->latest()
            ->paginate(10);

        return view('discussions.index', compact('discussions'));
    }

    // Create: Menyimpan pertanyaan baru
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'content' => 'required|string',
        ]);

        Discussion::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'category' => $request->category,
            'content' => $request->content,
            'status' => 'Menunggu'
        ]);

        return redirect()->back()->with('success', 'Pertanyaan berhasil dikirim ke forum!');
    }

    // Update: Mengedit pertanyaan user atau status oleh admin
    public function update(Request $request, $id)
    {
        $discussion = Discussion::findOrFail($id);
        
        // Cek apakah yang edit adalah pemilik atau admin
        if (Auth::id() !== $discussion->user_id && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $discussion->update($request->all());

        return redirect()->back()->with('success', 'Diskusi berhasil diperbarui.');
    }

    // Delete: Menghapus pertanyaan
    public function destroy($id)
    {
        $discussion = Discussion::findOrFail($id);

        if (Auth::id() !== $discussion->user_id && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $discussion->delete();

        return redirect()->back()->with('success', 'Diskusi berhasil dihapus.');
    }
}