<?php

namespace App\Http\Controllers;

use App\Models\Feed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SharedCalendarController extends Controller
{
    public function show(Request $request, $token)
    {
        $feed = Feed::where('token', $token)->with('sources')->firstOrFail();

        $mergedEvents = '';

        foreach ($feed->sources as $source) {
            try {
                $response = Http::get($source->ics_url);
                if ($response->successful()) {
                    $icsContent = $response->body();

                    // Simple regex to extract VEVENT blocks
                    preg_match_all('/BEGIN:VEVENT[\s\S]*?END:VEVENT/i', $icsContent, $matches);

                    if (! empty($matches[0])) {
                        $mergedEvents .= implode("\n", $matches[0])."\n";
                    }
                }
            } catch (\Exception $e) {
                // Log error or ignore failed source
                continue;
            }
        }

        $calendar = "BEGIN:VCALENDAR\n";
        $calendar .= "VERSION:2.0\n";
        $calendar .= "PRODID:-//CalMerge//MVP//EN\n";
        $calendar .= "CALSCALE:GREGORIAN\n";
        $calendar .= "METHOD:PUBLISH\n";
        $calendar .= $mergedEvents;
        $calendar .= 'END:VCALENDAR';

        return response($calendar, 200)
            ->header('Content-Type', 'text/calendar; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename="merged.ics"');
    }

    public function download($token)
    {
        // Reuse the show logic but force download
        $feed = Feed::where('token', $token)->with('sources')->firstOrFail();

        $mergedEvents = '';

        foreach ($feed->sources as $source) {
            try {
                $response = Http::get($source->ics_url);
                if ($response->successful()) {
                    $icsContent = $response->body();

                    preg_match_all('/BEGIN:VEVENT[\s\S]*?END:VEVENT/i', $icsContent, $matches);

                    if (! empty($matches[0])) {
                        $mergedEvents .= implode("\n", $matches[0])."\n";
                    }
                }
            } catch (\Exception $e) {
                continue;
            }
        }

        $calendar = "BEGIN:VCALENDAR\n";
        $calendar .= "VERSION:2.0\n";
        $calendar .= "PRODID:-//CalMerge//MVP//EN\n";
        $calendar .= "CALSCALE:GREGORIAN\n";
        $calendar .= "METHOD:PUBLISH\n";
        $calendar .= $mergedEvents;
        $calendar .= 'END:VCALENDAR';

        return response($calendar, 200)
            ->header('Content-Type', 'text/calendar; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename="calendar-'.$feed->token.'.ics"');
    }
}
