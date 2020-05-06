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
    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $from, string $tipe, string $pesan, array $data = ['tipe' => 'belakang', 'tema' => null])
    {
        $this->from = $from;
        $this->tipe = $tipe;
        $this->pesan = $pesan;
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
        if($this->data['tipe'] === 'belakang'){
            return $this->markdown('belakang.mail.NotifResiEmail')
                ->with([
                    'pesan' => $this->pesan
                ]);
        } else if($this->data['tipe'] === 'depan' && isset($this->data['tema'])){
            return $this->markdown('depan.'.$this->data['tema'].'.mail.NotifResiEmail')
                ->with([
                    'pesan' => $this->pesan
                ]);
        }
    }
}
