<?php

namespace App\Http\Controllers\Admin\Content;

use Illuminate\Http\Request;
use App\Models\Content\Comment;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Content\CommentRequest;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $unseenComments = Comment::where('seen', 0)->get();

        foreach ($unseenComments as $unseenComment) {
            $unseenComment->seen = 1;
            $unseenComment->save();
        }

       // $comments = Comment::orderBy('created_at', 'desc')->paginate(15);
        $comments = Comment::with('commentable')->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.content.comment.index', compact('comments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        return view('admin.content.comment.show', compact('comment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function status(Comment $comment)
    {
        $comment->status = $comment->status == 0 ? 1 : 0;
        $result = $comment->save();
        if ($result) {
            if ($comment->status == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {
            return response()->json(['status' => false]);
        }
    }

    public function approved(Comment $comment)
    {
        $comment->approved = $comment->approved == 0 ? 1 : 0;
        $result = $comment->save();
        if ($comment->approved == 1) {
            return redirect()->route('admin.content.comment.index')->with('toast-success', ' نظر با موفقیت تایید شد');
        } else if ($comment->approved == 0) {
            return redirect()->route('admin.content.comment.index')->with('toast-info', ' نظر با موفقیت در حالت عدم تایید قرار گرفت');
        } else {
            return redirect()->route('admin.content.comment.index')->with('toast-error', 'وضعیت نظر با خطا مواجه شد');
        }


    }

    public function answer(CommentRequest $request, Comment $comment)
    {
        if($comment->parent_id == null){
            $input = $request->all();
            $input['author_id'] = 1;
            $input['commentable_id'] = $comment->commentable_id;
            $input['parent_id'] = $comment->id;
            $input['commentable_type'] = $comment->commentable_type;
            $input['status'] = 1;
            $input['approved'] = 1;
            $commentReply = Comment::create($input);
            return redirect()->route('admin.content.comment.index')->with('toast-success', 'پاسخ با موفقیت ثبت شد');
        }else{
            return redirect()->route('admin.content.comment.index')->with('toast-error', 'پاسخ با خطا مواجه شد');
        }
    }
}
