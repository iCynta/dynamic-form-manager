<?php

namespace app\Mail;

use Illuminate\Notifications\Mailable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class FormCreationNotification extends Mailable
{
    use Queueable;

    public $data;

    /**
     * Create a new notification instance.
     *
     * @param array $data
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): self
    {
        return $this->subject('New Form Created!')
                    ->view('email_templates.form-creation', $this->data); // Replace with your view name
    }
}
