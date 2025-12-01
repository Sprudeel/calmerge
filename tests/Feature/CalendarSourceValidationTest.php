<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class CalendarSourceValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_validate_url_returns_events_for_valid_ics()
    {
        $user = User::factory()->create();

        Http::fake([
            'http://valid.ics' => Http::response("BEGIN:VCALENDAR\nBEGIN:VEVENT\nSUMMARY:Test Event\nDTSTART:20230101\nEND:VEVENT\nEND:VCALENDAR"),
        ]);

        $response = $this->actingAs($user)->postJson(route('calendar-sources.validate'), [
            'ics_url' => 'http://valid.ics',
        ]);

        $response->assertStatus(200);
        $response->assertJson(['valid' => true]);
        $response->assertJsonFragment(['summary' => 'Test Event']);
    }

    public function test_validate_url_returns_error_for_invalid_url()
    {
        $user = User::factory()->create();

        Http::fake([
            'http://invalid.ics' => Http::response('Not an ICS file', 404),
        ]);

        $response = $this->actingAs($user)->postJson(route('calendar-sources.validate'), [
            'ics_url' => 'http://invalid.ics',
        ]);

        $response->assertStatus(422);
        $response->assertJson(['valid' => false]);
    }

    public function test_validate_url_returns_error_for_empty_events()
    {
        $user = User::factory()->create();

        Http::fake([
            'http://empty.ics' => Http::response("BEGIN:VCALENDAR\nEND:VCALENDAR"),
        ]);

        $response = $this->actingAs($user)->postJson(route('calendar-sources.validate'), [
            'ics_url' => 'http://empty.ics',
        ]);

        $response->assertStatus(422);
        $response->assertJson(['valid' => false, 'message' => 'No events found in the ICS file.']);
    }
}
