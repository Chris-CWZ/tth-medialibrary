<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Event;

class RetrieveWeekends extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'retrieve:weekends';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Retrieving all weekends';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $weekends = new Event;
        $weekends->name = 'Closed';
    }
}
