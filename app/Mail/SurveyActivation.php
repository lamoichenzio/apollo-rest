<?php

namespace App\Mail;

use App\Survey;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SurveyActivation extends Mailable
{
    use Queueable, SerializesModels;

    public $survey;

    /**
     * Create a new message instance.
     *
     * @param Survey $survey
     */
    public function __construct(Survey $survey)
    {
        $this->survey = $survey;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->survey->active) {
            return $this->view('emails.activation');
        } else {
            return $this->view('emails.deactivation');
        }
    }
}
