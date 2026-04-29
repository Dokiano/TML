<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotifikasiReviewerBaru extends Mailable
{
    use Queueable, SerializesModels;

    public $dokumen;
    public $reviewer;

    public function __construct($dokumen, $reviewer)
    {
        $this->dokumen = $dokumen;
        $this->reviewer = $reviewer;
    }

    public function build()
    {
        return $this->subject('Permintaan Review Dokumen Baru')
                    ->view('emails.reviewer_notification');
    }
}