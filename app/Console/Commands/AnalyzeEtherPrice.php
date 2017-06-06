<?php

namespace App\Console\Commands;

use App\Services\EtherPriceService;
use Illuminate\Console\Command;

class AnalyzeEtherPrice extends Command
{
    protected $signature = 'ether:analyze';

    protected $description = 'Analyzes the current Ether price and handles large fluctuations.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(EtherPriceService $service)
    {
        $service->analyzePrice();
    }
}
