<?php

namespace App\Http\Controllers\admin\comment;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Rating;
use Illuminate\Http\Request;

class AdminCommentsController extends Controller
{
    public function index()
    {
        $comments = Comment::with(['customer.user', 'product'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        foreach ($comments as $comment) {
            $rating = Rating::where('customer_id', $comment->customer_id)
                ->where('product_id', $comment->product_id)
                ->first();

            $comment->rating_value = $rating?->rating ?? 0;
        }
        // dd($comment);
        return view('admin.comment.index', compact('comments'));
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return redirect()->back()->with('success', 'Đã ẩn bình luận.');
    }
    public function restore($id)
    {
        $comment = Comment::onlyTrashed()->findOrFail($id);
        $comment->restore();

        return redirect()->back()->with('success', 'Đã khôi phục bình luận.');
    }

    // Xóa vĩnh viễn
   public function forceDelete($id)
{
    $comment = Comment::withTrashed()->findOrFail($id);
    $comment->forceDelete();

    return redirect()->route('admin.comments.index')
        ->with('success', 'Đã xóa vĩnh viễn bình luận.');
}

public function show($id)
{
    $comment = Comment::withTrashed()
        ->with(['customer.user', 'product'])
        ->findOrFail($id);
        
    $rating = Rating::where('customer_id', $comment->customer_id)
        ->where('product_id', $comment->product_id)
        ->first();
    
    $comment->rating_value = $rating?->rating ?? 0;

    return view('admin.comment.show', compact('comment'));
}
    public function trashed()
    {
        $comments = Comment::onlyTrashed()
            ->with(['customer.user', 'product'])
            ->orderBy('deleted_at', 'desc')
            ->paginate(10);

        foreach ($comments as $comment) {
            $rating = Rating::where('customer_id', $comment->customer_id)
                ->where('product_id', $comment->product_id)
                ->first();

            $comment->rating_value = $rating?->rating ?? 0;
        }

        return view('admin.comment.trashed', compact('comments'));
    }
}
