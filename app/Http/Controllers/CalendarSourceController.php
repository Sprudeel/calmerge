<?php

namespace App\Http\Controllers;

use App\Models\CalendarSource;
use Illuminate\Http\Request;

class CalendarSourceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sources = CalendarSource::all();

        return view('calendar-sources.index', compact('sources'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $groups = \App\Models\Group::all();

        return view('calendar-sources.create', compact('groups'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'ics_url' => 'required|url',
            'groups' => 'array',
            'groups.*' => 'exists:groups,id',
            'access_token' => 'nullable|string|max:255',
        ]);

        $calendarSource = CalendarSource::create([
            'name' => $request->name,
            'ics_url' => $request->ics_url,
            'is_protected' => $request->has('is_protected'),
            'access_token' => $request->access_token,
        ]);

        if ($request->has('groups')) {
            $calendarSource->groups()->sync($request->groups);
        }

        return redirect()->route('calendar-sources.index')->with('success', 'Calendar source created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CalendarSource $calendarSource)
    {
        $groups = \App\Models\Group::all();

        return view('calendar-sources.edit', compact('calendarSource', 'groups'));
    }

    public function update(Request $request, CalendarSource $calendarSource)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'ics_url' => 'required|url',
            'groups' => 'array',
            'groups.*' => 'exists:groups,id',
            'access_token' => 'nullable|string|max:255',
        ]);

        $calendarSource->update([
            'name' => $request->name,
            'ics_url' => $request->ics_url,
            'is_protected' => $request->has('is_protected'),
            'access_token' => $request->access_token,
        ]);

        if ($request->has('groups')) {
            $calendarSource->groups()->sync($request->groups);
        } else {
            $calendarSource->groups()->detach();
        }

        return redirect()->route('calendar-sources.index')->with('success', 'Calendar source updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CalendarSource $calendarSource)
    {
        $calendarSource->delete();

        return redirect()->route('calendar-sources.index')->with('success', 'Calendar source deleted successfully.');
    }

    public function validateUrl(\Illuminate\Http\Request $request, \App\Services\IcsService $icsService)
    {
        $request->validate([
            'ics_url' => 'required|url',
        ]);

        $content = $icsService->fetchContent($request->input('ics_url'));

        if (! $content) {
            return response()->json(['valid' => false, 'message' => 'Could not fetch content from URL.'], 422);
        }

        $events = $icsService->extractEvents($content);

        if (empty($events)) {
            return response()->json(['valid' => false, 'message' => 'No events found in the ICS file.'], 422);
        }

        $preview = array_map(fn ($e) => $icsService->parseEvent($e), array_slice($events, 0, 5));

        return response()->json([
            'valid' => true,
            'events' => $preview,
        ]);
    }
}
