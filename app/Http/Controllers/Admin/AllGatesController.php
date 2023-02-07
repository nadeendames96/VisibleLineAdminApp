<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyAllGateRequest;
use App\Http\Requests\StoreAllGateRequest;
use App\Http\Requests\UpdateAllGateRequest;
use App\Models\AllGate;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AllGatesController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('all_gate_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $allGates = AllGate::all();

        return view('admin.allGates.index', compact('allGates'));
    }

    public function create()
    {
        abort_if(Gate::denies('all_gate_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.allGates.create');
    }

    public function store(StoreAllGateRequest $request)
    {
        $allGate = AllGate::create($request->all());

        return redirect()->route('admin.all-gates.index');
    }

    public function edit(AllGate $allGate)
    {
        abort_if(Gate::denies('all_gate_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.allGates.edit', compact('allGate'));
    }

    public function update(UpdateAllGateRequest $request, AllGate $allGate)
    {
        $allGate->update($request->all());

        return redirect()->route('admin.all-gates.index');
    }

    public function show(AllGate $allGate)
    {
        abort_if(Gate::denies('all_gate_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $allGate->load('gateNameAds');

        return view('admin.allGates.show', compact('allGate'));
    }

    public function destroy(AllGate $allGate)
    {
        abort_if(Gate::denies('all_gate_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $allGate->delete();

        return back();
    }

    public function massDestroy(MassDestroyAllGateRequest $request)
    {
        AllGate::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
