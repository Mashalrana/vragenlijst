<?php

// App\Mail\GeneratedHtmlMail.php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Email extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $htmlContent;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $htmlContent)
    {
        $this->subject = $subject;
        $this->htmlContent = $htmlContent;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)->html($this->htmlContent);
    }
}
