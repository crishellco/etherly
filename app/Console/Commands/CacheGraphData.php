<?php

namespace App\Console\Commands;

use App\Facades\EtherPrice;
use Illuminate\Console\Command;

class CacheGraphData extends Command
{
    protected $signature = 'ether:cache';

    protected $description = 'Caches ether graph data';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        EtherPrice::cacheGraphData();
    }
}
