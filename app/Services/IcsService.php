<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class IcsService
{
    public function fetchContent(string $url): ?string
    {
        try {
            $response = Http::timeout(5)->get($url);

            return $response->successful() ? $response->body() : null;
        } catch (\Exception $e) {
            return null;
        }
    }

    public function extractEvents(string $content): array
    {
        preg_match_all('/BEGIN:VEVENT[\s\S]*?END:VEVENT/i', $content, $matches);

        return $matches[0] ?? [];
    }

    public function parseEvent(string $eventBlock): array
    {
        $summary = $this->extractProperty($eventBlock, 'SUMMARY');
        $dtstart = $this->extractProperty($eventBlock, 'DTSTART');

        return [
            'summary' => $summary ?? 'No Title',
            'start' => $dtstart ?? 'Unknown',
        ];
    }

    private function extractProperty(string $content, string $property): ?string
    {
        if (preg_match('/'.$property.'[:;](.*)/', $content, $matches)) {
            // Handle cases where property might have params like DTSTART;VALUE=DATE:20230101
            // The regex above captures everything after the first : or ;
            // If it was ; we need to find the real value after the next :
            $value = trim($matches[1]);
            if (strpos($value, ':') !== false && strpos($content, $property.';') !== false) {
                $parts = explode(':', $value, 2);

                return isset($parts[1]) ? trim($parts[1]) : $value;
            }
            // Simple case: PROPERTY:Value
            // But wait, my regex /PROPERTY[:;](.*)/ might be too simple if there are params.
            // Let's try a slightly more robust one for the value.
        }

        // Better regex: match PROPERTY then optional params then : then value
        if (preg_match('/^'.$property.'(?:;[^:]*)?:(.*)$/m', $content, $matches)) {
            return trim($matches[1]);
        }

        return null;
    }
}
