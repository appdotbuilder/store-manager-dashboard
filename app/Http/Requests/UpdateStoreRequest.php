<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStoreRequest extends FormRequest
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
        return [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:stores,slug,' . $this->route('store')->id,
            'description' => 'nullable|string',
            'logo' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'address' => 'nullable|string',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'business_hours' => 'nullable|array',
            'delivery_areas' => 'nullable|array',
            'default_delivery_fee' => 'required|numeric|min:0',
            'currency' => 'required|string|size:3',
            'timezone' => 'required|string',
            'theme' => 'required|in:light,dark',
            'vat_percentage' => 'required|numeric|min:0|max:100',
            'payment_methods' => 'nullable|array',
            'settings' => 'nullable|array',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Store name is required.',
            'slug.required' => 'Store slug is required.',
            'slug.unique' => 'This store slug is already taken.',
            'currency.size' => 'Currency code must be exactly 3 characters.',
            'vat_percentage.max' => 'VAT percentage cannot exceed 100%.',
        ];
    }
}