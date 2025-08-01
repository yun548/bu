<?php

namespace App\Data;

class StoreData
{
    public string $name;
    public string $siret;
    public string $customs_code;
    public string $document_path;
    public array $activities;

    public function __construct(array $data)
    {
        $this->name = $data['name'] ?? '';
        $this->siret = $data['siret'] ?? '';
        $this->customs_code = $data['customs_code'] ?? '';
        $this->document_path = $data['document'] ?? '';
        $this->activities = $data['activities'] ?? [];
    }
}

