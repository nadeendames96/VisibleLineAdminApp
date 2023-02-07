@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.allGate.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.all-gates.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="gates_name">{{ trans('cruds.allGate.fields.gates_name') }}</label>
                <input class="form-control {{ $errors->has('gates_name') ? 'is-invalid' : '' }}" type="text" name="gates_name" id="gates_name" value="{{ old('gates_name', '') }}" required>
                @if($errors->has('gates_name'))
                    <span class="text-danger">{{ $errors->first('gates_name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.allGate.fields.gates_name_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection