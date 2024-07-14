<?php

namespace App\Http\Requests;

use App\Enums\UserRoleEnum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->user()['role_id'] === UserRoleEnum::ADMIN;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'is_featured' => 'nullable|boolean',
            'sku.*.name' => 'required|string|max:255',
            'sku.*.price' => 'required|decimal:2',
            'sku.*.quantity' => 'required|integer|min:1',
            'sku.*.images.*.url' => 'required|file|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }
}
