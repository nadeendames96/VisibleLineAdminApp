<?php

namespace App\Http\Requests;

use App\Models\AllGate;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateAllGateRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('all_gate_edit');
    }

    public function rules()
    {
        return [
            'gates_name' => [
                'string',
                'required',
                'unique:all_gates,gates_name,' . request()->route('all_gate')->id,
            ],
        ];
    }
}
