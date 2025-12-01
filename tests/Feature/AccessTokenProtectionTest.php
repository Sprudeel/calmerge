<?php

namespace Tests\Feature;

use App\Models\CalendarSource;
use App\Models\Feed;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccessTokenProtectionTest extends TestCase
{
    use RefreshDatabase;

    public function test_cannot_subscribe_to_hidden_source_without_token()
    {
        $source = CalendarSource::create([
            'name' => 'Hidden Source',
            'ics_url' => 'http://hidden.ics',
            'access_token' => 'secret-token',
        ]);

        $response = $this->post(route('feeds.store'), [
            'sources' => [$source->id],
            // No token provided
        ]);

        // Should fail, e.g. with validation error or 403
        // Currently it will succeed (200/302)
        $response->assertStatus(403);
    }

    public function test_can_subscribe_to_hidden_source_with_token()
    {
        $source = CalendarSource::create([
            'name' => 'Hidden Source',
            'ics_url' => 'http://hidden.ics',
            'access_token' => 'secret-token',
        ]);

        $response = $this->post(route('feeds.store'), [
            'sources' => [$source->id],
            'tokens' => 'secret-token', // We will implement this field
        ]);

        $response->assertRedirect();
        $this->assertEquals(1, Feed::count());
    }
}
