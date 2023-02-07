@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.allGate.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.all-gates.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.allGate.fields.id') }}
                        </th>
                        <td>
                            {{ $allGate->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.allGate.fields.gates_name') }}
                        </th>
                        <td>
                            {{ $allGate->gates_name }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.all-gates.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#gate_name_ads" role="tab" data-toggle="tab">
                {{ trans('cruds.ad.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="gate_name_ads">
            @includeIf('admin.allGates.relationships.gateNameAds', ['ads' => $allGate->gateNameAds])
        </div>
    </div>
</div>

@endsection