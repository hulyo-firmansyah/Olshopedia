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
    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $link, array $data = ['tipe' => 'belakang', 'tema' => null])
    {
        $this->user = $user;
        $this->link = $link;
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->data['tipe'] === 'belakang'){
            return $this->markdown('belakang.mail.ForgotPassword')
                ->with([
                    'link' => $this->link
                ]);
        } else if($this->data['tipe'] === 'depan' && isset($this->data['tema'])){
            return $this->markdown('depan.'.$this->data['tema'].'.mail.ForgotPassword')
                ->with([
                    'link' => $this->link
                ]);
        }
    }
}
