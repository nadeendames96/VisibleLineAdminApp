@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.ad.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.ads.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.ad.fields.id') }}
                        </th>
                        <td>
                            {{ $ad->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ad.fields.gate_name') }}
                        </th>
                        <td>
                            {{ $ad->gate_name->gates_name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ad.fields.video') }}
                        </th>
                        <td>
                            @if($ad->video)
                                <a href="{{ $ad->video->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ad.fields.image') }}
                        </th>
                        <td>
                            @if($ad->image)
                                <a href="{{ $ad->image->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $ad->image->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ad.fields.image_select') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $ad->image_select ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ad.fields.news') }}
                        </th>
                        <td>
                            {{ $ad->news }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ad.fields.time_entry') }}
                        </th>
                        <td>
                            {{ $ad->time_entry }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.ads.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection