<?php

namespace App\DataTransferObjects;

class PhysicalMedicalRecord
{
    public function __construct(
        public ?int $index,
        public ?string $medication,
        public ?string $dose,
        public ?string $frecuency,
        public ?string $reason,
        public ?string $preescribing_physician
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            index: $data['index'] ?? null,
            medication: $data['medication'] ?? null,
            dose: $data['dose'] ?? null,
            frecuency: $data['frecuency'] ?? null,
            reason: $data['reason'] ?? null,
            preescribing_physician: $data['preescribing_physician'] ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'index' => $this->index,
            'medication' => $this->medication,
            'dose' => $this->dose,
            'frecuency' => $this->frecuency,
            'reason' => $this->reason,
            'preescribing_physician' => $this->preescribing_physician
        ];
    }
}
