<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyAdRequest;
use App\Http\Requests\StoreAdRequest;
use App\Http\Requests\UpdateAdRequest;
use App\Models\Ad;
use App\Models\AllGate;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class AdsController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('ad_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ads = Ad::with(['gate_name', 'media'])->get();

        return view('admin.ads.index', compact('ads'));
    }

    public function create()
    {
        abort_if(Gate::denies('ad_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $gate_names = AllGate::pluck('gates_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.ads.create', compact('gate_names'));
    }

    public function store(StoreAdRequest $request)
    {
        $ad = Ad::create($request->all());

        // $request->validate([
        //     'file.*' => ['mimes:mp4']
        // ]);
    
        if ($request->input('video', false)) {
            $ad->addMedia(storage_path('tmp/uploads/' . basename($request->input('video'))))->toMediaCollection('video');
        }

        if ($request->input('image', false)) {
            $ad->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $ad->id]);
        }

        return redirect()->route('admin.ads.index');
    }

    public function edit(Ad $ad)
    {
        abort_if(Gate::denies('ad_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $gate_names = AllGate::pluck('gates_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $ad->load('gate_name');

        return view('admin.ads.edit', compact('ad', 'gate_names'));
    }

    public function update(UpdateAdRequest $request, Ad $ad)
    {
        $ad->update($request->all());

        if ($request->input('video', false)) {
            if (!$ad->video || $request->input('video') !== $ad->video->file_name) {
                if ($ad->video) {
                    $ad->video->delete();
                }
                $ad->addMedia(storage_path('tmp/uploads/' . basename($request->input('video'))))->toMediaCollection('video');
            }
        } elseif ($ad->video) {
            $ad->video->delete();
        }

        if ($request->input('image', false)) {
            if (!$ad->image || $request->input('image') !== $ad->image->file_name) {
                if ($ad->image) {
                    $ad->image->delete();
                }
                $ad->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
            }
        } elseif ($ad->image) {
            $ad->image->delete();
        }

        return redirect()->route('admin.ads.index');
    }

    public function show(Ad $ad)
    {
        abort_if(Gate::denies('ad_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ad->load('gate_name');

        return view('admin.ads.show', compact('ad'));
    }

    public function destroy(Ad $ad)
    {
        abort_if(Gate::denies('ad_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ad->delete();

        return back();
    }

    public function massDestroy(MassDestroyAdRequest $request)
    {
        Ad::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('ad_create') && Gate::denies('ad_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Ad();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
