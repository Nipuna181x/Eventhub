<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class StoreEventRequest extends FormRequest
{
    public function authorize()
{
    return auth()->check() && auth()->user()->role === 'admin';
}

public function rules()
{
    return [
        'title' => 'required|string|max:255',
        'description' => 'required',
        'venue' => 'required|string|max:255',
        'date' => 'required|date|after:today',
        'time' => 'required',
        'capacity' => 'required|integer|min:1',
    ];
}

}
