<?php

namespace App\Console\Commands;

use App\Models\BlockedDate;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DeleteExpiredBlockedDates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete-expired-blocked-dates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete expired blocked dates from the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();
        
        $count = BlockedDate::where('date', '<', $today)->delete();
        
        $this->info("Deleted {$count} expired blocked dates.");
        
        return Command::SUCCESS;
    }
}
