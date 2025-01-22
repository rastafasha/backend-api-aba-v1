<?php

namespace App\Casts;

use App\DataTransferObjects\PhysicalMedicalRecord;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use InvalidArgumentException;

class PhysicalMedicalCast implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        if ($value === null) {
            return [];
        }

        $records = json_decode($value, true);
        return array_map(
            fn ($record) => PhysicalMedicalRecord::fromArray($record),
            $records ?? []
        );
    }

    public function set($model, string $key, $value, array $attributes)
    {
        if ($value === null) {
            return null;
        }

        if (is_array($value)) {
            $records = array_map(function ($record) {
                if ($record instanceof PhysicalMedicalRecord) {
                    return $record->toArray();
                }
                return $record;
            }, $value);
            return json_encode($records);
        }

        throw new InvalidArgumentException('The given value is not an array of physical and medical records.');
    }
}
