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
        $url = ' https://twitter.com/intent/tweet?text=My GitHub Evaluation%0AName : ' . $this->result->name .
        '%0APublic Repo : ' . $this->result->public_repo .
        '%0AContributions : ' . $this->result->commit_sum .
        '%0AIssues : ' . $this->result->issues .
        '%0APull Requests : ' . $this->result->pull_requests .
        '%0AStar : ' . $this->result->star_sum .
        '%0AFollowers : ' . $this->result->followers .
        '%0ARank : ' . $this->result->user_rank .
        '%0A&hashtags=engineerEvaluation';
        return $this->markdown('emails.result',[
            'url' => $url,
        ]);
    }
}
