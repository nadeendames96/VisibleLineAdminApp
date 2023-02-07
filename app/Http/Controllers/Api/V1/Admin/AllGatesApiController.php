<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAllGateRequest;
use App\Http\Requests\UpdateAllGateRequest;
use App\Http\Resources\Admin\AllGateResource;
use App\Models\AllGate;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AllGatesApiController extends Controller
{
    public function index()
    {
        // abort_if(Gate::denies('all_gate_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AllGateResource(AllGate::all());
    }

    public function store(StoreAllGateRequest $request)
    {
        $allGate = AllGate::create($request->all());

        return (new AllGateResource($allGate))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(AllGate $allGate)
    {
        abort_if(Gate::denies('all_gate_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AllGateResource($allGate);
    }

    public function update(UpdateAllGateRequest $request, AllGate $allGate)
    {
        $allGate->update($request->all());

        return (new AllGateResource($allGate))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(AllGate $allGate)
    {
        abort_if(Gate::denies('all_gate_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $allGate->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
