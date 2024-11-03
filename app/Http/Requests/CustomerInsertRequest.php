<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerInsertRequest extends FormRequest
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
            Add a customer to the customers list, the data will be sent as a JSON in the request body :
            {
                "title": "Mr",
                "name": "Adrien Philippe",
                "gender": "M",
                "phone_number": "085222334445",
                "image": "https://img.freepik.com/premium-vector/man-avatar-profile-round-icon_24640-14044.jpg",
                "email": "adrien.philippe@gmail.com"
            }
        */
        return [
            // Title ada kemungkinan mr mrs pakai titik dan tidak, sepertinya tidak masalah
            'title' => ['required', 'string', Rule::in(['Mr.', 'Mr', 'Mrs.', 'Mrs', 'Sir', 'Madam'])],
            'name' => ['required', 'string', 'min:2', 'max:255'],
            // Pastikan gender hanya M,F
            'gender' => ['required', 'string', 'min:1', 'max:1', Rule::in(["M", 'F'])],
            // Berdasarkan https://worldpopulationreview.com/country-rankings/phone-number-length-by-country,
            // minimal 4 karakter, max 17. Menggunakan laravel-phone untuk validasi nomor telp
            'phone_number' => ['required', 'min:4', 'max:17', 'phone:ID,INTERNATIONAL'],
            'image' => ['required', 'url'],
            'email' => ['required', 'email', 'unique:customers,email'],
        ];
    }
}
