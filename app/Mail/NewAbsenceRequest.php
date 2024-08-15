<?php

namespace App\Mail;

use App\Models\DemandeAbsence;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewAbsenceRequest extends Mailable
{
    use Queueable, SerializesModels;

    public $demandeAbsence;

    /**
     * Create a new message instance.
     */
    public function __construct(DemandeAbsence $demandeAbsence)
    {
        $this->demandeAbsence = $demandeAbsence;
    }

    public function build()
    {
        return $this->subject('Nouvelle demande d\'absence')
            ->view('emails.new-absence-request');
    }
}