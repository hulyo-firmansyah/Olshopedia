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
    public $tipe_;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $from, string $tipe, string $pesan, string $tipe_ = 'belakang')
    {
        $this->from = $from;
        $this->tipe = $tipe;
        $this->pesan = $pesan;
        $this->tipe_ = $tipe_;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->from($this->from['alamat'], $this->from['nama']);
        return $this->markdown($this->tipe_.'.mail.NotifResiEmail')
            ->with([
                'pesan' => $this->pesan
            ]);
    }
}
