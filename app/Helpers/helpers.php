<?php

if (!function_exists('format_number')) {
    function format_number($number)
    {
        if ($number >= 1000000) {
            return number_format($number / 1000000, 1) . 'M';
        } elseif ($number >= 1000) {
            return number_format($number / 1000, 1) . 'K';
        }
        return number_format($number);
    }
}

if (!function_exists('reading_time')) {
    function reading_time($content)
    {
        $wordCount = str_word_count(strip_tags($content));
        $minutes = max(1, ceil($wordCount / 250));
        return $minutes . ' Menit';
    }
}