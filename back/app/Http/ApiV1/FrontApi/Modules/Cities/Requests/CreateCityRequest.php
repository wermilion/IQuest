<?php

namespace App\Http\ApiV1\FrontApi\Modules\Cities\Requests;

use App\Http\ApiV1\FrontApi\Support\Requests\BaseFormRequest;

class CreateCityRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'name'  =>  ['required', 'string']
        ];
    }
}
