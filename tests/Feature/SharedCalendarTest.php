<?php

use App\Models\CalendarSource;
use App\Models\Feed;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class SharedCalendarTest extends TestCase
{
    use RefreshDatabase;

    public function test_shared_calendar_returns_merged_ics()
    {
        Http::fake([
            'http://a.ics' => Http::response("BEGIN:VCALENDAR\nBEGIN:VEVENT\nSUMMARY:Event A\nEND:VEVENT\nEND:VCALENDAR"),
            'http://b.ics' => Http::response("BEGIN:VCALENDAR\nBEGIN:VEVENT\nSUMMARY:Event B\nEND:VEVENT\nEND:VCALENDAR"),
        ]);

        $sourceA = CalendarSource::create(['name' => 'Source A', 'ics_url' => 'http://a.ics']);
        $sourceB = CalendarSource::create(['name' => 'Source B', 'ics_url' => 'http://b.ics']);

        $feed = Feed::create([
            'token' => 'test-token',
            'signature' => 'test-signature',
        ]);
        $feed->sources()->attach([$sourceA->id, $sourceB->id]);

        $response = $this->get(route('shared.calendar', 'test-token'));

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/calendar; charset=utf-8');

        $content = $response->content();
        $this->assertStringContainsString('SUMMARY:Event A', $content);
        $this->assertStringContainsString('SUMMARY:Event B', $content);
        $this->assertStringContainsString('BEGIN:VCALENDAR', $content);
        $this->assertStringContainsString('END:VCALENDAR', $content);
    }

    public function test_invalid_token_returns_404()
    {
        $response = $this->get(route('shared.calendar', 'invalid-token'));

        $response->assertStatus(404);
    }
}
