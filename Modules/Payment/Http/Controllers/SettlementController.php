<?php

namespace Modules\Payment\Http\Controllers;

use App\Http\Controllers\Controller;

use Modules\Payment\Entities\Settlement;
use Modules\Payment\Services\SettlementService;
use Modules\RolePermission\Entities\Permission;
use Modules\Payment\Repositories\SettlementRepo;
use Modules\Payment\Http\Requests\SettlementRequest;



class SettlementController extends Controller
{
    public function index(SettlementRepo $repo)
    {
        $this->authorize('index', Settlement::class);
        if (auth()->user()->can(Permission::PERMISSION_MANAGE_SETTLEMENTS))
            $settlements = $repo->latest()->paginate();
        else
            $settlements = $repo->paginateUserSettlements(auth()->id());
        return view("payment::settlements.index", compact("settlements"));
    }

    public function create(SettlementRepo $repo)
    {
        $this->authorize('store', Settlement::class);
        if ($repo->getLatestPendingSettlement(auth()->id())){
            // newFeedback("ناموفق", "شما یک درخواست تسویه در حال انتظار دارید و نمیتوانید درخواست جدیدی فعلا ثبت بکنید.", "error");
            return  redirect()->route("settlements.index");
        }
        return view("payment::settlements.create");
    }

    public function store(SettlementRequest $request, SettlementRepo $repo)
    {
        $this->authorize('store', Settlement::class);
        if ($repo->getLatestPendingSettlement(auth()->id())){
            // newFeedback("ناموفق", "شما یک درخواست تسویه در حال انتظار دارید و نمیتوانید درخواست جدیدی فعلا ثبت بکنید.", "error");
            return  redirect()->route("settlements.index");
        }
        SettlementService::store($request->all());
        return redirect(route("settlements.index"));
    }

    public function edit($settlementId, SettlementRepo $repo)
    {
        $requestedSettlement = $repo->find($settlementId);
        $settlement = $repo->getLatestSettlement($requestedSettlement->user_id);
        $this->authorize('manage', Settlement::class);
        if ($settlement->id != $settlementId){
            // newFeedback("ناموفق", "این درخواست تسویه قابل ویرایش نیست و بایگانی شده است. فقط آخرین درخواست تسویه ی هر کاربر قابل ویرایش است.", "error");
            return  redirect()->route("settlements.index");
        }

        return view("payment::settlements.edit", compact("settlement"));
    }

    public function update($settlementId, SettlementRequest $request, SettlementRepo $repo)
    {
        $requestedSettlement = $repo->find($settlementId);
        $settlement = $repo->getLatestSettlement($requestedSettlement->user_id);
        $this->authorize('manage', Settlement::class);
        if ($settlement->id != $settlementId){
            // newFeedback("ناموفق", "این درخواست تسویه قابل ویرایش نیست و بایگانی شده است. فقط آخرین درخواست تسویه ی هر کاربر قابل ویرایش است.", "error");
            return  redirect()->route("settlements.index");
        }
        SettlementService::update($settlementId, $request->all());
        return redirect(route("settlements.index"));
    }
}
