<?php

namespace App\Console\Commands;

use App\Service\CalculateRankInterface;
use Illuminate\Console\Command;

class EvaluateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:evaluate 
                            {name : the username}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Evaluate the engineer from name';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(CalculateRankInterface $calc)
    {
        parent::__construct();
        $this->calc = $calc;
    }

    /**
     *エンジニアを評価する専用のコマンド
     * @return object {name,public_repo,commit_sum,issues,pull_requests,star_sum,followers,user_rank}
     */
    public function handle() : object
    {
        $name = $this->argument('name');
        return $this->calc->evaluation($name);
    }
}
