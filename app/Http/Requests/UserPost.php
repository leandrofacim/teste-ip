<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserPost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nome' => 'required',
            'email' => 'required',
            'telefone' => 'required',
            'endereco' => 'required',
            'curriculo' => 'required|mimes:pdf,doc,docx,txt|max:500',
        ];
    }

    public function messages()
    {
        return [
           'nome.require' => 'campo nome obrigatório',
           'email.require' => 'campo email obrigatório' ,
           'telefone.require' => 'campo telefone obrigatório',
           'endereco.require' => 'campo endereco obrigatório',
           'curriculo.require' => 'campo curriculo obrigatório',
        ];
    }
}
