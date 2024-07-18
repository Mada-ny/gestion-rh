<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NouveauCompteEmploye extends Mailable
{
    use Queueable, SerializesModels;

    public $employe;
    public $nomUtilisateur;
    public $motDePasseTemporaire;

    public function __construct($employe, $nomUtilisateur, $motDePasseTemporaire)
    {
        $this->employe = $employe;
        $this->nomUtilisateur = $nomUtilisateur;
        $this->motDePasseTemporaire = $motDePasseTemporaire;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: 'madanydoumbia09@gmail.com',
            subject: 'Vos identifiants de connexion',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.nouveau-compte-employe',
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