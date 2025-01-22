<?php

namespace App\DataTransferObjects;

class AttentionRecord
{
    public function __construct(
        public ?int $index,
        public ?string $preventive_strategies,
        public ?string $replacement_skills,
        public ?string $manager_strategies
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            index: $data['index'] ?? null,
            preventive_strategies: $data['preventive_strategies'] ?? null,
            replacement_skills: $data['replacement_skills'] ?? null,
            manager_strategies: $data['manager_strategies'] ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'index' => $this->index,
            'preventive_strategies' => $this->preventive_strategies,
            'replacement_skills' => $this->replacement_skills,
            'manager_strategies' => $this->manager_strategies
        ];
    }
}

