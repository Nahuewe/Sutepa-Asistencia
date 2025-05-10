<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuariosRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre'       => 'required|string|max:255',
            'apellido'     => 'required|string|max:255',
            'password'     => 'required|string|max:255',
            'roles_id'     => 'required|exists:roles,id',
            'seccional_id' => 'nullable|exists:seccional,id',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required'   => 'El campo nombre es obligatorio.',
            'nombre.string'     => 'El campo nombre debe ser una cadena de texto.',
            'nombre.max'        => 'El campo nombre no puede tener más de 255 caracteres.',
            'apellido.required' => 'El campo apellido es obligatorio.',
            'apellido.string'   => 'El campo apellido debe ser una cadena de texto.',
            'apellido.max'      => 'El campo apellido no puede tener más de 255 caracteres.',
            'password.required' => 'El campo contraseña es obligatorio.',
            'password.string'   => 'El campo contraseña debe ser una cadena de texto.',
            'password.max'      => 'El campo contraseña no puede tener más de 255 caracteres.',
            'roles_id.required' => 'El campo rol es obligatorio.',
            'roles_id.exists'   => 'El rol seleccionado no es válido.',
        ];
    }
}
