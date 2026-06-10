<?php

namespace App\Jobs;

use App\Mail\NewsletterMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendNewsletterJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $subscriberEmail;
    public $subject;
    public $content;

    /**
     * Create a new job instance.
     */
    public function __construct($subscriberEmail, $subject, $content)
    {
        $this->subscriberEmail = $subscriberEmail;
        $this->subject = $subject;
        $this->content = $content;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->subscriberEmail)
            ->send(new NewsletterMail($this->subject, $this->content, $this->subscriberEmail));
    }
}
