<?php

namespace App\Http\Requests;

use App\Models\Cotizacion;

use Illuminate\Foundation\Http\FormRequest;

class CreateCotizacionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return Cotizacion::$rules;
    }
}
