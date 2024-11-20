<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait GeneratesUniqueCode
{
    /**
     * Generate a unique code.
     *
     * @param int $length Length of the unique code.
     * @return string
     */
    public function generateUniqueCode($length = 12)
    {
        // Generate a unique code using a combination of time and randomness
        $timestamp = now()->timestamp; // Current timestamp
        $random = strtoupper(Str::random($length - strlen($timestamp))); // Random string
         
        // Combine timestamp and random string
        return $timestamp . $random;
    }
}
