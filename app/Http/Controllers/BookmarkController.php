<?php

namespace App\Http\Controllers;

use App\Models\Tweet;

class BookmarkController extends Controller
{
    // ブックマーク一覧を表示
    public function index()
    {
        $tweets = auth()->user()
            ->bookmarks()
            ->with(['user', 'liked'])
            ->latest('tweets.created_at')
            ->paginate(10);

        return view('bookmarks.index', compact('tweets'));
    }

    // ブックマークを追加
    public function store(Tweet $tweet)
    {
        auth()->user()
            ->bookmarks()
            ->syncWithoutDetaching([$tweet->id]);

        return back();
    }

    // ブックマークを解除
    public function destroy(Tweet $tweet)
    {
        auth()->user()
            ->bookmarks()
            ->detach($tweet->id);

        return back();
    }
}