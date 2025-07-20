<?php

namespace Tests\Unit;

use App\Console\Commands\DeleteUnverifiedBookings;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteUnverifiedBookingsTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_it_deletes_unverified_bookings_older_than_two_days(): void
    {
        // Régi, nem megerősített foglalás (ezt törölni kell)
        Booking::factory()->create([
            'created_at' => Carbon::now()->subDays(3),
            'verified_at' => null
        ]);

        // Régi, megerősített foglalás (ezt meg kell tartani)
        Booking::factory()->create([
            'created_at' => Carbon::now()->subDays(3),
            'verified_at' => Carbon::now()->subDays(2)
        ]);

        // Új, nem megerősített foglalás (ezt meg kell tartani)
        Booking::factory()->create([
            'created_at' => Carbon::now()->subHours(12),
            'verified_at' => null
        ]);

        // Futtatjuk a parancsot
        $this->artisan('bookings:prune-unverified')
            ->expectsOutput('Deleted 1 unverified bookings older than 2 days.')
            ->assertSuccessful();

        // Ellenőrizzük, hogy csak 2 foglalás maradt
        $this->assertCount(2, Booking::all());
    }
}