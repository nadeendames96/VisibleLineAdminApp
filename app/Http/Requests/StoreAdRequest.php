<?php

namespace App\Http\Requests;

use App\Models\Ad;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreAdRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('ad_create');
    }

    public function rules()
    {
        return [
            'gate_name_id' => [
                'required',
                'integer',
            ],
            'news' => [
                'string',
                'nullable',
            ],
            'time_entry' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
