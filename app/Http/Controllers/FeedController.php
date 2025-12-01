<?php

namespace App\Http\Controllers;

use App\Models\CalendarSource;
use App\Models\Feed;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FeedController extends Controller
{
    public function create(Request $request)
    {
        // Get access tokens from URL (comma-separated)
        $tokens = $request->query('token') ? explode(',', $request->query('token')) : [];

        // Get all groups with their calendars
        $groups = \App\Models\Group::with(['calendars' => function ($query) use ($tokens) {
            $query->where(function ($q) use ($tokens) {
                // Show calendars with no access_token OR with matching token
                $q->whereNull('access_token');
                if (! empty($tokens)) {
                    $q->orWhereIn('access_token', $tokens);
                }
            });
        }])->get();

        // Get calendars not in any group
        $ungrouped = \App\Models\CalendarSource::whereDoesntHave('groups')
            ->where(function ($q) use ($tokens) {
                $q->whereNull('access_token');
                if (! empty($tokens)) {
                    $q->orWhereIn('access_token', $tokens);
                }
            })
            ->get();

        return view('feeds.create', compact('groups', 'ungrouped', 'tokens'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sources' => 'required|array|min:1',
            'sources.*' => 'exists:calendar_sources,id',
            'tokens' => 'nullable|string',
        ]);

        $sourceIds = $request->input('sources');
        $providedTokens = $request->input('tokens') ? explode(',', $request->input('tokens')) : [];

        // Verify access to protected sources
        $sources = CalendarSource::whereIn('id', $sourceIds)->get();
        foreach ($sources as $source) {
            if ($source->access_token && ! in_array($source->access_token, $providedTokens)) {
                abort(403, 'Unauthorized access to hidden calendar: '.$source->name);
            }
        }

        sort($sourceIds);

        // Include password hash in signature to allow different passwords for same sources
        // or same sources with/without password (if allowed)
        $signatureData = implode(',', $sourceIds);

        $signature = hash('sha256', $signatureData);

        $feed = Feed::firstOrCreate(
            ['signature' => $signature],
            [
                'token' => Str::random(10),
            ]
        );

        if ($feed->wasRecentlyCreated) {
            $feed->sources()->attach($sourceIds);
        }

        return redirect()->route('feeds.show', $feed->token);
    }

    public function show($token)
    {
        $feed = Feed::where('token', $token)->firstOrFail();

        return view('feeds.show', compact('feed'));
    }
}
