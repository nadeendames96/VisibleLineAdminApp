<div class="m-3">
    @can('upload_file_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.upload-files.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.uploadFile.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.uploadFile.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-placeNameUploadFiles">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                            <th>
                                {{ trans('cruds.uploadFile.fields.id') }}
                            </th>
                            <th>
                                {{ trans('cruds.uploadFile.fields.video') }}
                            </th>
                            <th>
                                {{ trans('cruds.uploadFile.fields.image') }}
                            </th>
                            <th>
                                {{ trans('cruds.uploadFile.fields.news') }}
                            </th>
                            <th>
                                {{ trans('cruds.uploadFile.fields.time_ads') }}
                            </th>
                            <th>
                                {{ trans('cruds.uploadFile.fields.place_name') }}
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($uploadFiles as $key => $uploadFile)
                            <tr data-entry-id="{{ $uploadFile->id }}">
                                <td>

                                </td>
                                <td>
                                    {{ $uploadFile->id ?? '' }}
                                </td>
                                <td>
                                    @foreach($uploadFile->video as $key => $media)
                                        <a href="{{ $media->getUrl() }}" target="_blank">
                                            {{ trans('global.view_file') }}
                                        </a>
                                    @endforeach
                                </td>
                                <td>
                                    @if($uploadFile->image)
                                        <a href="{{ $uploadFile->image->getUrl() }}" target="_blank" style="display: inline-block">
                                            <img src="{{ $uploadFile->image->getUrl('thumb') }}">
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    {{ $uploadFile->news ?? '' }}
                                </td>
                                <td>
                                    {{ $uploadFile->time_ads ?? '' }}
                                </td>
                                <td>
                                    {{ $uploadFile->place_name->place_name ?? '' }}
                                </td>
                                <td>
                                    @can('upload_file_show')
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.upload-files.show', $uploadFile->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan

                                    @can('upload_file_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.upload-files.edit', $uploadFile->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan

                                    @can('upload_file_delete')
                                        <form action="{{ route('admin.upload-files.destroy', $uploadFile->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                        </form>
                                    @endcan

                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('upload_file_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.upload-files.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'asc' ]],
    pageLength: 50,
  });
  let table = $('.datatable-placeNameUploadFiles:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection