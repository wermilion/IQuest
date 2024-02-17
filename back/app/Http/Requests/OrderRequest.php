<?php

namespace App\Http\Requests;

use App\Enums\ObtainingMethodEnum;
use App\Enums\PaymentMethodEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class OrderRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['string', 'max:200', 'required', 'not_regex:/[0-9]/'],
            'phone' => ['max:18', 'required'],
            'email' => ['email', 'nullable', 'max:255'],
            'comment' => ['string', 'max:1000', 'nullable'],
            'obtainingMethod' => ['required', new Enum(ObtainingMethodEnum::class)],
            'paymentMethod' => ['required', new Enum(PaymentMethodEnum::class)],
            'receiptDate' => ['required', 'after_or_equal:today'],
            'receiptTime' => ['required'],
            'street' => ['max:255', 'required'],
            'house' => ['max:255', 'required'],
            'flat' => ['max:255', 'nullable'],
            'entrance' => ['max:255'],
            'floor' => ['max:255', 'nullable'],
            'intercom' => ['max:255', 'nullable'],
            'dishes' => ['array']
        ];
    }
}
