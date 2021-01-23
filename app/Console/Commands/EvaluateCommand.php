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
                            {id : the id to evaluate}';

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
     * @return int 結果を格納したidを返す
     */
    public function handle()
    {
        $id = $this->argument('id');
        $this->calc->evaluation($id);
    }
}
