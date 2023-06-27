<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestTask extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
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
            'titulo' => 'required|string|max:45',
            'descricao' => 'string|max:200',
            'conteudo' => 'max:16777215',
            'prazo' => 'required|date',

        ];
    }

	/**
	 * Get the error messages for the defined validation rules.
	 *
	 * @return array
	 */
	public function messages()
	{
		return [
			'titulo.required' => __('validation.required'),
            'titulo.string' => __('validation.string'),
            'titulo.max' => __('validation.max'),

            'descricao.string' => __('validation.string'),
            'descricao.max' => __('validation.max'),

            'conteudo.max' => __('validation.max'),

            'prazo.date' => __('validation.date'),
            'prazo.max' => __('validation.max'),
        ];
    }
}
