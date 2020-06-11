<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class GuestOrder extends Mailable
{
    use Queueable, SerializesModels;

    public $from;
    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $from, $data)
    {
        $this->from = $from;
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->from($this->from['alamat'], $this->from['nama']);
        return $this->markdown('depan.all.mail.GuestOrder')
            ->with([
                'data' => $this->data
            ]);
    }
}
