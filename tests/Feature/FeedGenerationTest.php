<?php

use App\Models\CalendarSource;
use App\Models\Feed;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FeedGenerationTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_page_loads_with_sources()
    {
        CalendarSource::create(['name' => 'Source A', 'ics_url' => 'http://a.ics']);
        CalendarSource::create(['name' => 'Source B', 'ics_url' => 'http://b.ics']);

        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee('Source A');
        $response->assertSee('Source B');
    }

    public function test_creating_feed_generates_token_and_signature()
    {
        $sourceA = CalendarSource::create(['name' => 'Source A', 'ics_url' => 'http://a.ics']);
        $sourceB = CalendarSource::create(['name' => 'Source B', 'ics_url' => 'http://b.ics']);

        $response = $this->post(route('feeds.store'), [
            'sources' => [$sourceA->id, $sourceB->id],
        ]);

        $feed = Feed::first();
        $this->assertNotNull($feed);
        $this->assertNotNull($feed->token);
        $this->assertNotNull($feed->signature);
        $this->assertEquals(2, $feed->sources()->count());

        $response->assertRedirect(route('feeds.show', $feed->token));
    }

    public function test_deduplication_returns_same_feed()
    {
        $sourceA = CalendarSource::create(['name' => 'Source A', 'ics_url' => 'http://a.ics']);
        $sourceB = CalendarSource::create(['name' => 'Source B', 'ics_url' => 'http://b.ics']);

        // First creation
        $this->post(route('feeds.store'), [
            'sources' => [$sourceA->id, $sourceB->id],
        ]);
        $firstFeed = Feed::first();

        // Second creation with same sources (different order shouldn't matter if we sort)
        $this->post(route('feeds.store'), [
            'sources' => [$sourceB->id, $sourceA->id],
        ]);

        $this->assertEquals(1, Feed::count());
        $this->assertEquals($firstFeed->id, Feed::first()->id);
    }

    public function test_validation_requires_sources()
    {
        $response = $this->post(route('feeds.store'), [
            'sources' => [],
        ]);

        $response->assertSessionHasErrors('sources');
    }
}
