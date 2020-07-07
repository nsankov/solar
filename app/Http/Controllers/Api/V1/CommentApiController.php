<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\CommentUpdateRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use \Illuminate\Http\Response;

class CommentApiController extends Controller
{
    /**
     * @param $postId
     * @return CommentResource
     */
    public function index($postId)
    {
        return new CommentResource(Comment::getTree($postId));
    }

    public function store($postId, CommentRequest $request)
    {
        $comment = Comment::addNew(array_merge($request->validated(), ['post_id' => $postId] ));

        return (new CommentResource($comment))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function update(CommentUpdateRequest $request, Comment $comment)
    {
        $comment->update($request->validated());

        return (new CommentResource($comment))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Comment $comment)
    {
        $comment->update(['status' => Comment::STATUS_DELETE]);

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
