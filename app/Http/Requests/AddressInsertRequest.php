<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressInsertRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        /*
            Add a address to the address list, the data will be sent as a JSON in the request body :
            {
                "address" : "Kawasan Karyadeka Pancamurni Blok A Kav. 3",
                "district" : "Cikarang Selatan",
                "city" : "Bekasi",
                "province" : "Jawa Barat",
                "postal_code" : 17530
            }
        */
        return [
            //
            "address" => ['required', 'string', 'min:3', 'max:255'],
            "district" => ['required', 'string', 'min:3', 'max:255'],
            "city" => ['required', 'string', 'min:3', 'max:255'],
            "province" => ['required', 'string', 'min:3', 'max:255'],
            // Sementara postal code tidak pakai library dulu
            "postal_code" => ['required', 'integer', 'min:6'],
            // Tidak ada customer_id?
            "customer_id" => ['required', 'integer', 'exists:customers,id']
        ];
    }
}
