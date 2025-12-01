<?php

use App\Models\CalendarSource;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CalendarSourceTest extends TestCase
{
    use RefreshDatabase;

    public function test_unauthenticated_users_cannot_access_calendar_sources()
    {
        $response = $this->get(route('calendar-sources.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_users_can_view_calendar_sources()
    {
        $user = User::factory()->create();
        $source = CalendarSource::create([
            'name' => 'Test Calendar',
            'ics_url' => 'https://example.com/calendar.ics',
        ]);

        $response = $this->actingAs($user)->get(route('calendar-sources.index'));

        $response->assertStatus(200);
        $response->assertSee('Test Calendar');
    }

    public function test_authenticated_users_can_create_calendar_source()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('calendar-sources.store'), [
            'name' => 'New Calendar',
            'ics_url' => 'https://example.com/new.ics',
            'is_protected' => 'on',
        ]);

        $response->assertRedirect(route('calendar-sources.index'));
        $this->assertDatabaseHas('calendar_sources', [
            'name' => 'New Calendar',
            'ics_url' => 'https://example.com/new.ics',
            'is_protected' => true,
        ]);
    }

    public function test_authenticated_users_can_update_calendar_source()
    {
        $user = User::factory()->create();
        $source = CalendarSource::create([
            'name' => 'Old Name',
            'ics_url' => 'https://example.com/old.ics',
        ]);

        $response = $this->actingAs($user)->put(route('calendar-sources.update', $source), [
            'name' => 'Updated Name',
            'ics_url' => 'https://example.com/updated.ics',
            'is_protected' => 'on',
        ]);

        $response->assertRedirect(route('calendar-sources.index'));
        $this->assertDatabaseHas('calendar_sources', [
            'id' => $source->id,
            'name' => 'Updated Name',
            'ics_url' => 'https://example.com/updated.ics',
            'is_protected' => true,
        ]);
    }

    public function test_authenticated_users_can_delete_calendar_source()
    {
        $user = User::factory()->create();
        $source = CalendarSource::create([
            'name' => 'To Delete',
            'ics_url' => 'https://example.com/delete.ics',
        ]);

        $response = $this->actingAs($user)->delete(route('calendar-sources.destroy', $source));

        $response->assertRedirect(route('calendar-sources.index'));
        $this->assertDatabaseMissing('calendar_sources', [
            'id' => $source->id,
        ]);
    }

    public function test_validation_rules()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('calendar-sources.store'), [
            'name' => '',
            'ics_url' => 'not-a-url',
        ]);

        $response->assertSessionHasErrors(['name', 'ics_url']);
    }
}
