<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordCode extends Mailable
{
    use SerializesModels;

    public $code;
    public $username;

    public function __construct($code, $username)
    {
        $this->code = $code;
        $this->username = $username;
    }

    public function build()
    {
        return $this
            ->subject('Reset Password Request')
            ->view('emails.reset_password_code')
            ->with([
                'code' => $this->code,
                'username' => $this->username,
            ]);
    }
}