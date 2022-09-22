<?php

namespace Modules\Comment\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Modules\Comment\Entities\Comment;
use Modules\Common\Responses\AjaxResponses;
use Illuminate\Contracts\Support\Renderable;
use Modules\Comment\Repositories\CommentRepo;
use Modules\RolePermission\Entities\Permission;
use Modules\Comment\Http\Requests\CommentRequest;

class CommentController extends Controller
{
    public function index(CommentRepo $repo)
    {
        $this->authorize('index', Comment::class);
        $comments = $repo
            ->searchBody(request("body"))
            ->searchEmail(request("email"))
            ->searchName(request("name"))
            ->searchStatus(request("status"));

        if (!auth()->user()->hasAnyPermission(Permission::PERMISSION_MANAGE_COMMENTS, Permission::PERMISSION_SUPER_ADMIN)) {
            $comments->query->whereHasMorph("commentable", [Course::class] , function ($query) {
                return $query->where("teacher_id", auth()->id());
            })->where("status", Comment::STATUS_APPROVED);
        }

        $comments = $comments->paginateParents();

        return view("comment::index", compact("comments"));
    }

    public function show($comment)
    {
        $comment = Comment::query()->where("id", $comment)->with("commentable", "user", "comments")->firstOrFail();
        $this->authorize('view', $comment);
        return view("comment::show", compact("comment"));
    }

    public function store(CommentRequest $request, CommentRepo $repo)
    {
        $comment = $repo->store($request->all());
        event(new CommentSubmittedEvent($comment));
        newFeedback("عملیات موفقیت آمیز", "دیدگاه شما با موفقیت ثبت گردید.");
        return back();
    }

    public function accept($id, CommentRepo $commentRepo)
    {
        $this->authorize('manage', Comment::class);
        $comment = $commentRepo->findOrFail($id);
        if ($commentRepo->updateStatus($id, Comment::STATUS_APPROVED)) {
            CommentApprovedEvent::dispatch($comment);
            return AjaxResponses::SuccessResponse();
        }

        return AjaxResponses::FailedResponse();
    }

    public function reject($id, CommentRepo $commentRepo)
    {
        $this->authorize('manage', Comment::class);
        $comment = $commentRepo->findOrFail($id);
        if ($commentRepo->updateStatus($id, Comment::STATUS_REJECTED)) {
            CommentRejectedEvent::dispatch($comment);
            return AjaxResponses::SuccessResponse();
        }

        return AjaxResponses::FailedResponse();
    }

    public function destroy($id, CommentRepo $repo)
    {
        $this->authorize('manage', Comment::class);
        $comment = $repo->findOrFail($id);
        $comment->delete();
        return AjaxResponses::SuccessResponse();
    }
}
