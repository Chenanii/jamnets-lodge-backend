<?php


namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;


class StoreLivestockRequest extends FormRequest
{
public function authorize() { return true; }


public function rules()
{
    return [
    'type' => 'required|string|max:100',
    'total_count' => 'required|integer|min:0',
    'alive_count' => 'nullable|integer|min:0',
    'sick_count' => 'nullable|integer|min:0',
    'dead_count' => 'nullable|integer|min:0',
    'recorded_at' => 'nullable|date',
    'notes' => 'nullable|string',
    ];
}
}