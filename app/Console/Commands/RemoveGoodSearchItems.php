<?php

namespace App\Console\Commands;

use App\GoodSearchItem;
use Carbon\Carbon;
use Illuminate\Console\Command;

class RemoveGoodSearchItems extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'autoremove:good';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Autoremove GoodSearchItems';

    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $deleted = GoodSearchItem::whereRaw('ifnull(`load_date_to`, `load_date`) < ?', [Carbon::now()->startOfDay()])
            ->delete();
        $this->info(sprintf('Total removed: %d good(s)', $deleted));
    }
}
