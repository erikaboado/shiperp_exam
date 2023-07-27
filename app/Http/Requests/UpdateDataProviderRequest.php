<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDataProviderRequest extends FormRequest
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
                'unique:data_providers,name,' . request('data_provider') . ',id,deleted_at,NULL'
            ],
            'url' => [
                'required',
                'url',
                'unique:data_providers,url,' . request('data_provider') . ',id,deleted_at,NULL'
            ]
        ];
    }
}
