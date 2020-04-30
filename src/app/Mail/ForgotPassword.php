<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ForgotPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $link;
    public $tipe;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $link, string $tipe = 'belakang')
    {
        $this->user = $user;
        $this->link = $link;
        $this->tipe = $tipe;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown($this->tipe.'.mail.ForgotPassword')
            ->with([
                'link' => $this->link
            ]);
    }
}
