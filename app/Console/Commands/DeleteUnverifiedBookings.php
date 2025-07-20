<?php

namespace App\Console\Commands;

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DeleteUnverifiedBookings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    //protected $signature = 'app:delete-unverified-bookings';
    protected $signature = 'bookings:prune-unverified';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes unverified bookings that are older than 2 days.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $cutoffDate = Carbon::now()->subDays(2);
        
        $count = Booking::whereNull('verified_at')
            ->where('created_at', '<', $cutoffDate)
            ->delete();
        
        $this->info("Deleted {$count} unverified bookings older than 2 days.");
        
        return Command::SUCCESS;
    }
}
