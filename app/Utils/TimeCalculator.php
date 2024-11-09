<?php

namespace App\Utils;

use Carbon\Carbon;
use DateTimeInterface;

class TimeCalculator
{
    /**
     * Calculate the time difference between two timestamps
     * 
     * @param string|Carbon|DateTimeInterface $startTime
     * @param string|Carbon|DateTimeInterface $endTime
     * @param string $format Format to return the difference ('hours', 'minutes', 'seconds', 'array', 'string')
     * @return mixed
     */
    public static function timeDifference($startTime, $endTime, string $format = 'array')
    {
        // Convert inputs to Carbon instances
        $start = static::parseTime($startTime);
        $end = static::parseTime($endTime);
        
        // Calculate the difference
        $diff = $end->diff($start);
        
        // Return based on requested format
        switch($format) {
            case 'hours':
                return ($diff->h + ($diff->days * 24)) + $diff->i / 60;
            
            case 'minutes':
                return ($diff->h + ($diff->days * 24)) * 60 + $diff->i;
            
            case 'seconds':
                return (($diff->h + ($diff->days * 24)) * 60 + $diff->i) * 60 + $diff->s;
            
            case 'string':
                return static::formatDifference($diff);
            
            case 'array':
                return [
                    'days' => $diff->days,
                    'hours' => $diff->h,
                    'minutes' => $diff->i,
                    'seconds' => $diff->s,
                    'total_hours' => ($diff->h + ($diff->days * 24)) + $diff->i / 60,
                    'total_minutes' => ($diff->h + ($diff->days * 24)) * 60 + $diff->i,
                    'total_seconds' => (($diff->h + ($diff->days * 24)) * 60 + $diff->i) * 60 + $diff->s,
                ];
            
            default:
                throw new \InvalidArgumentException("Invalid format specified");
        }
    }
    
    /**
     * Parse various time formats into Carbon instance
     */
    private static function parseTime($time): Carbon
    {
        if ($time instanceof Carbon) {
            return $time;
        }
        
        if ($time instanceof DateTimeInterface) {
            return Carbon::instance($time);
        }
        
        return Carbon::parse($time);
    }
    
    /**
     * Format the time difference into a human-readable string
     */
    private static function formatDifference($diff): string
    {
        $parts = [];
        
        if ($diff->days > 0) {
            $parts[] = $diff->days . ' day' . ($diff->days !== 1 ? 's' : '');
        }
        if ($diff->h > 0) {
            $parts[] = $diff->h . ' hour' . ($diff->h !== 1 ? 's' : '');
        }
        if ($diff->i > 0) {
            $parts[] = $diff->i . ' minute' . ($diff->i !== 1 ? 's' : '');
        }
        if ($diff->s > 0 || empty($parts)) {
            $parts[] = $diff->s . ' second' . ($diff->s !== 1 ? 's' : '');
        }
        
        return implode(', ', $parts);
    }
}