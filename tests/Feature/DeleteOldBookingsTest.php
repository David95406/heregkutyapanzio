<?php

namespace Tests\Unit;

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteOldBookingsTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_it_deletes_bookings_older_than_sixty_days(): void
    {
        // 1. Régi foglalás (több mint 60 napja véget ért) - ezt törölni kell
        $oldBooking = Booking::factory()->create([
            'start_date' => Carbon::now()->subDays(90),
            'end_date' => Carbon::now()->subDays(85),  // 85 napja véget ért
        ]);

        // 2. Új foglalás (kevesebb mint 60 napja ért véget) - ezt meg kell tartani
        $recentBooking = Booking::factory()->create([
            'start_date' => Carbon::now()->subDays(70),
            'end_date' => Carbon::now()->subDays(55),  // 55 napja ért véget
        ]);

        // 3. Jövőbeli foglalás - ezt is meg kell tartani
        $futureBooking = Booking::factory()->create([
            'start_date' => Carbon::now()->addDays(10),
            'end_date' => Carbon::now()->addDays(20),
        ]);

        // Futtatjuk a parancsot
        $this->artisan('bookings:delete-old')
            ->expectsOutput('Deleted 1 old booking(s) that ended more than 60 days ago.')
            ->assertSuccessful();

        // Ellenőrizzük, hogy csak 2 foglalás maradt
        $this->assertCount(2, Booking::all());
        
        // Ellenőrizzük, hogy a régi foglalás törlődött
        $this->assertDatabaseMissing('bookings', ['id' => $oldBooking->id]);
        
        // Ellenőrizzük, hogy a többi megmaradt
        $this->assertDatabaseHas('bookings', ['id' => $recentBooking->id]);
        $this->assertDatabaseHas('bookings', ['id' => $futureBooking->id]);
    }
}