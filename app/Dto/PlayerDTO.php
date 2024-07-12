<?php

namespace App\Dto;

class PlayerDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $birth_date,
        public readonly string $image_url,
    ) {}

    public static function fromArray(array $data) 
    {
        return new self(
            name: strval(data_get($data, 'display_name')),
            birth_date: strval(data_get($data, 'date_of_birth')),
            image_url: strval(data_get($data, 'image_path')),
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'birth_date' => $this->birth_date,
            'image_url' => $this->image_url,
        ];
    }
}