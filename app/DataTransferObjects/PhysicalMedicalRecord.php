<?php

namespace App\DataTransferObjects;

class PhysicalMedicalRecord
{
    public function __construct(
        public ?int $index,
        public ?string $medication,
        public ?string $dose,
        public ?string $frequency,
        public ?string $reason,
        public ?string $preescribing_physician
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            index: $data['index'] ?? null,
            medication: $data['medication'] ?? null,
            dose: $data['dose'] ?? null,
            frequency: $data['frequency'] ?? null,
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
            'frequency' => $this->frequency,
            'reason' => $this->reason,
            'preescribing_physician' => $this->preescribing_physician
        ];
    }
}
