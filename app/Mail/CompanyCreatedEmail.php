<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CompanyCreatedEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $companyName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($companyName)
    {
        $this->companyName = $companyName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('COMPANY CREATED SUCCESSFULLY')
        ->view('emails.companyCreated');

    }
}
