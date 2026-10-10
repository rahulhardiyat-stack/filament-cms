<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function store(Request $request, $articleSlug)
    {
        $article = Article::where('slug', $articleSlug)
            ->published()
            ->firstOrFail();

        $validator = Validator::make($request->all(), [
            'author_name' => 'required|string|max:255',
            'author_email' => 'required|email|max:255',
            'content' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:comments,id'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $comment = Comment::create([
            'article_id' => $article->id,
            'parent_id' => $request->parent_id,
            'author_name' => $request->author_name,
            'author_email' => $request->author_email,
            'content' => $request->content,
            'is_approved' => false, // Need admin approval
        ]);

        return redirect()->back()
            ->with('success', 'Komentar Anda telah dikirim dan menunggu persetujuan.');
    }
}