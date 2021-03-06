<?php

namespace App\Console\Commands;

use App\Mail\SendResult;
use App\Repositories\UserRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendResultCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:sendresult
                            {id : whitch result to send}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send the mail to the address';

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
     * 誰宛かを受け取ってその宛先に結果を送信
     *
     * @return void
     */
    public function handle():void
    {
        $id = $this->argument('id');
        $repo = new UserRepository();
        $result = $repo->getResult($id);
        Mail::to($result->email)->send(new SendResult($result));
    }
}
