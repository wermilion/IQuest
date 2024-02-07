<?php

namespace App\Console\Commands;

use App\Domain\Quests\Models\Quest;
use Illuminate\Console\Command;

class Debug extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:debug';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Debug some things';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Quest::query()->find(1)->update([
            'is_active' => false,
        ]);
    }
}
