@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.ad.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.ads.update", [$ad->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="gate_name_id">{{ trans('cruds.ad.fields.gate_name') }}</label>
                <select class="form-control select2 {{ $errors->has('gate_name') ? 'is-invalid' : '' }}" name="gate_name_id" id="gate_name_id" required>
                    @foreach($gate_names as $id => $entry)
                        <option value="{{ $id }}" {{ (old('gate_name_id') ? old('gate_name_id') : $ad->gate_name->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('gate_name'))
                    <span class="text-danger">{{ $errors->first('gate_name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.ad.fields.gate_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="video">{{ trans('cruds.ad.fields.video') }}</label>
                <div class="needsclick dropzone {{ $errors->has('video') ? 'is-invalid' : '' }}" id="video-dropzone">
                </div>
                @if($errors->has('video'))
                    <span class="text-danger">{{ $errors->first('video') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.ad.fields.video_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="image">{{ trans('cruds.ad.fields.image') }}</label>
                <div class="needsclick dropzone {{ $errors->has('image') ? 'is-invalid' : '' }}" id="image-dropzone">
                </div>
                @if($errors->has('image'))
                    <span class="text-danger">{{ $errors->first('image') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.ad.fields.image_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('image_select') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="image_select" value="0">
                    <input class="form-check-input" type="checkbox" name="image_select" id="image_select" value="1" {{ $ad->image_select || old('image_select', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="image_select">{{ trans('cruds.ad.fields.image_select') }}</label>
                </div>
                @if($errors->has('image_select'))
                    <span class="text-danger">{{ $errors->first('image_select') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.ad.fields.image_select_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="news">{{ trans('cruds.ad.fields.news') }}</label>
                <input class="form-control {{ $errors->has('news') ? 'is-invalid' : '' }}" type="text" name="news" id="news" value="{{ old('news', $ad->news) }}">
                @if($errors->has('news'))
                    <span class="text-danger">{{ $errors->first('news') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.ad.fields.news_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="time_entry">{{ trans('cruds.ad.fields.time_entry') }}</label>
                <input class="form-control {{ $errors->has('time_entry') ? 'is-invalid' : '' }}" type="number" name="time_entry" id="time_entry" value="{{ old('time_entry', $ad->time_entry) }}" step="1" required>
                @if($errors->has('time_entry'))
                    <span class="text-danger">{{ $errors->first('time_entry') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.ad.fields.time_entry_helper') }}</span>
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

@section('scripts')
<script>
    Dropzone.options.videoDropzone = {
    url: '{{ route('admin.ads.storeMedia') }}',
    maxFilesize: 500, // MB
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 500
    },
    success: function (file, response) {
      $('form').find('input[name="video"]').remove()
      $('form').append('<input type="hidden" name="video" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="video"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($ad) && $ad->video)
      var file = {!! json_encode($ad->video) !!}
          this.options.addedfile.call(this, file)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="video" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}
</script>
<script>
    Dropzone.options.imageDropzone = {
    url: '{{ route('admin.ads.storeMedia') }}',
    maxFilesize: 500, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 500,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').find('input[name="image"]').remove()
      $('form').append('<input type="hidden" name="image" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="image"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($ad) && $ad->image)
      var file = {!! json_encode($ad->image) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="image" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
@endif
    },
    error: function (file, response) {
        if ($.type(response) === 'string') {
            var message = response //dropzone sends it's own error messages in string
        } else {
            var message = response.errors.file
        }
        file.previewElement.classList.add('dz-error')
        _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
        _results = []
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
            node = _ref[_i]
            _results.push(node.textContent = message)
        }

        return _results
    }
}

</script>
@endsection