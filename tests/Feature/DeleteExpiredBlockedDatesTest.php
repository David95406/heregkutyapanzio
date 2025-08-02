<?php

namespace Tests\Unit\Commands;

use App\Models\BlockedDate;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteExpiredBlockedDatesTest extends TestCase
{
    use RefreshDatabase;

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_deletes_expired_blocked_dates()
    {
        // Rögzített dátum a teszteléshez
        $now = Carbon::parse('2023-06-15');
        Carbon::setTestNow($now);

        // Lejárt dátumok létrehozása (a mai nap előttiek)
        BlockedDate::create(['date' => $now->copy()->subDays(1)]); // tegnap
        BlockedDate::create(['date' => $now->copy()->subDays(5)]); // 5 nappal ezelőtt
        BlockedDate::create(['date' => $now->copy()->subMonth()]);  // előző hónap

        // Nem lejárt dátumok létrehozása (mai és jövőbeli)
        BlockedDate::create(['date' => $now]); // ma
        BlockedDate::create(['date' => $now->copy()->addDays(1)]); // holnap
        BlockedDate::create(['date' => $now->copy()->addMonth()]); // következő hónap

        // Ellenőrizzük, hogy 6 dátum létezik
        $this->assertEquals(6, BlockedDate::count());

        // Parancs futtatása
        $this->artisan('delete-expired-blocked-dates')
            ->expectsOutput('Deleted 3 expired blocked dates.')
            ->assertExitCode(0);

        // Ellenőrizzük, hogy csak a nem lejárt dátumok maradtak meg (3)
        $this->assertEquals(3, BlockedDate::count());
        
        // Ellenőrizzük, hogy a mai és jövőbeli dátumok megmaradtak
        // A LIKE operátort használjuk, hogy csak a dátum részt ellenőrizzük
        $this->assertDatabaseHas('blocked_dates', ['date' => $now->format('Y-m-d H:i:s')]);
        $this->assertDatabaseHas('blocked_dates', ['date' => $now->copy()->addDays(1)->format('Y-m-d H:i:s')]);
        $this->assertDatabaseHas('blocked_dates', ['date' => $now->copy()->addMonth()->format('Y-m-d H:i:s')]);
        
        // Ellenőrizzük, hogy a lejárt dátumok törlődtek
        $this->assertDatabaseMissing('blocked_dates', ['date' => $now->copy()->subDays(1)->format('Y-m-d H:i:s')]);
        $this->assertDatabaseMissing('blocked_dates', ['date' => $now->copy()->subDays(5)->format('Y-m-d H:i:s')]);
        $this->assertDatabaseMissing('blocked_dates', ['date' => $now->copy()->subMonth()->format('Y-m-d H:i:s')]);
        
        // Teszt végeztével visszaállítjuk a Carbon-t
        Carbon::setTestNow(null);
    }
    
    #[\PHPUnit\Framework\Attributes\Test]
    public function it_returns_zero_when_no_expired_dates()
    {
        // Rögzített dátum a teszteléshez
        $now = Carbon::parse('2023-06-15');
        Carbon::setTestNow($now);
        
        // Csak jövőbeli dátumok
        BlockedDate::create(['date' => $now]); // ma
        BlockedDate::create(['date' => $now->copy()->addDays(1)]); // holnap
        
        // Parancs futtatása
        $this->artisan('delete-expired-blocked-dates')
            ->expectsOutput('Deleted 0 expired blocked dates.')
            ->assertExitCode(0);
            
        // Ellenőrizzük, hogy semmi sem törlődött
        $this->assertEquals(2, BlockedDate::count());
        
        // Teszt végeztével visszaállítjuk a Carbon-t
        Carbon::setTestNow(null);
    }
}