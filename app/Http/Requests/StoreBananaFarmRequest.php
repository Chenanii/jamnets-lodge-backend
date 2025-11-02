<?php


namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;


class StoreBananaFarmRequest extends FormRequest
{
    public function authorize() { return true; }


    public function rules()
    {
        return [
            'farm_name' => 'nullable|string|max:150',
            'total_trees' => 'required|integer|min:0',
            'fruiting_trees' => 'nullable|integer|min:0',
            'sick_trees' => 'nullable|integer|min:0',
            'dead_trees' => 'nullable|integer|min:0',
            'recorded_at' => 'nullable|date',
            'notes' => 'nullable|string',
        ];
    }
}