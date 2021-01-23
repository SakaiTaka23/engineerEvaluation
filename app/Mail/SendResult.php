<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendResult extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * object インスタンス
     * @var object {name,email,public_repo,commit_sum,issues,pull_requests,star_sum,followers}
     */
    public $result;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(object $result)
    {
        $this->result = $result;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.result');
    }
}
