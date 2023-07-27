<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateDataProviderRequest extends FormRequest
{
    /**
     * Rules
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string','max:100',
                'unique:data_providers,name,NULL,id,deleted_at,NULL'
            ],
            'url' => [
                'required',
                'url',
                'unique:data_providers,url,NULL,id,deleted_at,NULL'
            ]
        ];
    }
}
