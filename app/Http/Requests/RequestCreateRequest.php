<?php

namespace App\Http\Requests;

use App\Models\Request;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class RequestCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        /** @var User $user */
        $user = auth()->user();

        return $user->can('create', Request::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        /** @var User $user */
        $user = auth()->user();

        return [
            'target' => [
                'required',
                'numeric',
                'exists:users,id',
                function ($attribute, $value, $fail) use ($user) {
                    if ($value === $user->id) {
                        $fail(__('validation.exists', [
                            'attribute' => $attribute
                        ]));
                    }
                }
            ]
        ];
    }
}
