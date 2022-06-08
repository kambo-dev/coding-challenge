<?php

namespace App\Http\Requests;

use App\Enums\RequestStatuses;
use App\Models\Request;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class RequestUpdateRequest extends FormRequest
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

        $request = Request::query()
            ->findOrFail(request()->route('request_id'));

        return $user->can('update', $request);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'status' => 'required|string|in:'.RequestStatuses::toString()
        ];
    }
}
