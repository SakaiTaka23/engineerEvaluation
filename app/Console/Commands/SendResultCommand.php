<?php

namespace App\Console\Commands;

use App\Mail\SendMock;
use App\Mail\SendResult;
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
                            {to : where to send the mail}';

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
    public function __construct(object $result)
    {
        parent::__construct();
        $this->result = $result;
    }

    /**
     * 誰宛かを受け取ってその宛先に結果を送信
     *
     * @return void
     */
    public function handle():void
    {
        $to = $this->argument('to');
        Mail::to($to)->send(new SendResult($this->result));
    }
}
