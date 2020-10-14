<?php

namespace App\Mail;

use App\Survey;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SurveyInvitation extends Mailable
{
    use Queueable, SerializesModels;

    public $survey;
    public $password;
    public $surveyUrl;

    /**
     * Create a new message instance.
     *
     * @param Survey $survey
     * @param string $password
     * @param string $surveyUrl
     */
    public function __construct(Survey $survey, string $password, string $surveyUrl)
    {
        $this->survey = $survey;
        $this->password = $password;
        $this->surveyUrl = rtrim($surveyUrl, '/');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.invitation');
    }
}
