<?php

namespace Modules\Ticket\Http\Controllers;

use Illuminate\Http\Request;

use Modules\Ticket\Entities\Reply;
use Modules\Ticket\Entities\Ticket;
use App\Http\Controllers\Controller;
use Modules\Ticket\Services\ReplyService;
use Modules\Common\Responses\AjaxResponses;
use Modules\Ticket\Repositories\TicketRepo;
use Illuminate\Contracts\Support\Renderable;
use Modules\Ticket\Http\Requests\ReplyRequest;
use Modules\RolePermission\Entities\Permission;
use Modules\Ticket\Http\Requests\TicketRequest;

class TicketController extends Controller
{
    public function index(TicketRepo $repo, Request $request)
    {
        if(auth()->user()->can(Permission::PERMISSION_MANAGE_TICKETS)){
            $tickets = $repo->joinUsers()
                ->searchEmail($request->email)
                ->searchName($request->name)
                ->searchTitle($request->title)
                ->searchDate(dateFromJalali($request->date))
                ->searchStatus($request->status)
                ->paginate();
             
        }else{
            $tickets = $repo->paginateAll(auth()->id());

        }
        return view("ticket::index", compact("tickets"));
    }

    public function show($ticket, TicketRepo $repo)
    {
        $ticket = $repo->findOrFailWithReplies($ticket);
        $this->authorize("show", $ticket);
        return view("ticket::show", compact("ticket"));
    }

    public function create()
    {
        return view("ticket::create");
    }

    public function store(TicketRequest $request, TicketRepo $repo)
    {
        $ticket = $repo->store($request->title);
        ReplyService::store($ticket, $request->body, $request->attachment);
        newFeedback();
        return redirect()->route("tickets.index");
    }

    public function reply(Ticket $ticket, ReplyRequest $request)
    {
        $this->authorize("show", $ticket);
        ReplyService::store($ticket, $request->body, $request->attachment);
        newFeedback();
        return redirect()->route("tickets.show", $ticket->id);
    }

    public function close(Ticket $ticket, TicketRepo $repo)
    {
        $this->authorize("show", $ticket);
        $repo->setStatus($ticket->id, Ticket::STATUS_CLOSE);
        newFeedback();
        return redirect()->route("tickets.index");
    }

    public function destroy(Ticket $ticket)
    {
        $this->authorize("delete", $ticket);
        $hasAttachments = Reply::query()->where("ticket_id", $ticket->id)->whereNotNull("media_id")->with("media")->get();
        foreach ($hasAttachments as $reply){
            $reply->media->delete();
        }
        $ticket->delete();
        return AjaxResponses::SuccessResponse();
    }


}
