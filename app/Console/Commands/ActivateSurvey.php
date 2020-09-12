<?php

namespace App\Console\Commands;

use App\Services\SurveyService;
use Illuminate\Console\Command;

class ActivateSurvey extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'activate:surveys {date}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Activates or deactivates the surveys based on the start or end date attribute';

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
     * @param SurveyService $service
     * @return void
     */
    public function handle(SurveyService $service)
    {
        $date = $this->argument('date');
        $service->activateSurveys($date, $date);
    }
}
