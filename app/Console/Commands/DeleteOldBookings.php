<?php

namespace App\Console\Commands;

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class DeleteOldBookings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookings:delete-old';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete bookings that ended more than 60 days ago';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $cutoffDate = Carbon::now()->subDays(60);
        
        $count = Booking::where('end_date', '<', $cutoffDate)
            ->delete();
        
        $this->info("Deleted {$count} old booking(s) that ended more than 60 days ago.");
        
        // Opcionális: naplózás hozzáadása
        Log::info("DeleteOldBookings futott: {$count} régi foglalás törölve");
        
        return Command::SUCCESS;
    }
}
