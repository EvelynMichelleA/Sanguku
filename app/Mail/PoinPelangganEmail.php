<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PoinPelangganEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $pelanggan;
    public $poinSebelum;
    public $poinDigunakan;
    public $poinDihasilkan;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pelanggan, $poinSebelum, $poinDigunakan, $poinDihasilkan)
    {
        $this->pelanggan = $pelanggan;
        $this->poinSebelum = $poinSebelum;
        $this->poinDigunakan = $poinDigunakan;
        $this->poinDihasilkan = $poinDihasilkan;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Informasi Poin Pelanggan')
                    ->view('emails.poin_pelanggan');
    }
}
