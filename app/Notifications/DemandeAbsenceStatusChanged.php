<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\DemandeAbsence;

class DemandeAbsenceStatusChanged extends Notification
{
    use Queueable;

    protected $demandeAbsence;

    public function __construct(DemandeAbsence $demandeAbsence)
    {
        $this->demandeAbsence = $demandeAbsence;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        $status = ucfirst($this->demandeAbsence->statut);
        $dateDebut = $this->demandeAbsence->date_debut->format('d/m/Y');
        $dateFin = $this->demandeAbsence->date_fin->format('d/m/Y');

        return (new MailMessage)
                    ->subject("Mise à jour de votre demande d'absence")
                    ->line("Le statut de votre demande d'absence a été mis à jour.")
                    ->line("Nouveau statut : $status")
                    ->line("Période : du $dateDebut au $dateFin")
                    ->action('Voir les détails', route('demande-absences.index'))
                    ->line("Si vous avez des questions, veuillez contacter votre responsable.");
    }

    public function toArray($notifiable)
    {
        return [
            'demande_absence_id' => $this->demandeAbsence->id,
            'statut' => $this->demandeAbsence->statut,
            'date_debut' => $this->demandeAbsence->date_debut->toDateString(),
            'date_fin' => $this->demandeAbsence->date_fin->toDateString(),
        ];
    }
}