<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Model;
use JetBrains\PhpStorm\ArrayShape;

class ServiceResponse
{
    private bool $success;

    private ?Model $model;

    private ?string $message;

    private ?array $data;

    public function __construct(
        bool $success,
        Model $model = null,
        string $message = null,
        array $data = null
    ) {
        $this->success = $success;
        $this->model = $model;
        $this->message = $message;
        $this->data = $data;
    }

    public function success(): bool
    {
        return $this->success;
    }

    public function message(): ?string
    {
        return $this->message;
    }

    public function model(): ?Model
    {
        return $this->model;
    }

    public function data(): ?array
    {
        return $this->data;
    }

    public function toArray(): array
    {
        return [
            'success' => $this->success,
            'message' => $this->message,
            'model'   => $this->model,
            'data'    => $this->data
        ];
    }

    public function toJson(): bool|string
    {
        return json_encode($this->toArray());
    }
}
