<?php

namespace App\Mail;

use App\Models\Pelanggan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use App\Models\TransaksiPenjualan;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class InfoPoin extends Mailable
{
    use Queueable, SerializesModels;
    public $pelanggan;
    public $diskon;
    public $poinBaru;

    /**
     * Create a new message instance.
     *
     * @param Pelanggan $pelanggan
     * @param int $diskon
     * @param int $poinBaru
     * @return void
    
     * Create a new message instance.
     */
    public function __construct(Pelanggan $pelanggan, $diskon, $poinBaru)
    {
        $this->pelanggan = $pelanggan;
        $this->diskon = $diskon;
        $this->poinBaru = $poinBaru;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Info Poin',
            from: 'sanguku.cafe@gmail.com'
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.info-poin',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
