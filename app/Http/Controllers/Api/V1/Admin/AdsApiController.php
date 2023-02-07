<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreAdRequest;
use App\Http\Requests\UpdateAdRequest;
use App\Http\Resources\Admin\AdResource;
use App\Models\Ad;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdsApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        // abort_if(Gate::denies('ad_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AdResource(Ad::with(['gate_name'])->get());
    }

    public function store(StoreAdRequest $request)
    {
        $ad = Ad::create($request->all());

        if ($request->input('video', false)) {
            $ad->addMedia(storage_path('tmp/uploads/' . basename($request->input('video'))))->toMediaCollection('video');
        }

        if ($request->input('image', false)) {
            $ad->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
        }

        return (new AdResource($ad))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Ad $ad)
    {
        abort_if(Gate::denies('ad_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AdResource($ad->load(['gate_name']));
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

        return (new AdResource($ad))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Ad $ad)
    {
        abort_if(Gate::denies('ad_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ad->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
