<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifResiEmailAddon extends Mailable
{
    use Queueable, SerializesModels;

    public $pesan;
    public $tipe;
    public $from;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $from, string $tipe, string $pesan)
    {
        $this->from = $from;
        $this->tipe = $tipe;
        $this->pesan = $pesan;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->from($this->from['alamat'], $this->from['nama']);
        return $this->markdown('belakang.mail.NotifResiEmail')
            ->with([
                'pesan' => $this->pesan
            ]);
    }
}
