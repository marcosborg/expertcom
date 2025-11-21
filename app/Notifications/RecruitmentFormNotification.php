<?php

namespace App\Notifications;

use App\Models\RecruitmentForm;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RecruitmentFormNotification extends Notification
{
    use Queueable;

    private $recruitmentForm;
    private $subject;

    public function __construct($recruitmentForm, $subject)
    {
        $this->recruitmentForm = $recruitmentForm;
        $this->subject = $subject;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject($this->subject)
            ->line('<strong>Submetido por: </strong>' . $this->recruitmentForm->user->name)
            ->line('<strong>Nome do candidato: </strong>' . $this->recruitmentForm->name)
            ->line('<strong>Email do candidato: </strong>' . $this->recruitmentForm->email)
            ->line('<strong>Telefone: </strong>' . $this->recruitmentForm->phone)
            ->line('<strong>Contacto efetuado com sucesso: </strong>' . ($this->recruitmentForm->contact_successfully == 1 ? 'Sim' : 'Nao'))
            ->line('<strong>Contacto: </strong>' . $this->recruitmentForm->phone)
            ->line('<strong>Agendou entrevista: </strong>' . ($this->recruitmentForm->scheduled_interview == 1  ? 'Sim' : 'Nao'))
            ->line('<strong>Data da entrevista: </strong>' . $this->recruitmentForm->appointment)
            ->line('<strong>Realizada?: </strong>' . ($this->recruitmentForm->done == 1 ? 'Sim' : 'Nao'))
            ->line('<strong>Observacoes: </strong>' . $this->recruitmentForm->comments)
            ->line('<strong>Estado da lead: </strong>' . $this->recruitmentForm->status)
            ->line('<strong>Motivo de nao recrutamento: </strong>' . ($this->recruitmentForm->not_recruited_reason ? (RecruitmentForm::NOT_RECRUITED_REASON_RADIO[$this->recruitmentForm->not_recruited_reason] ?? $this->recruitmentForm->not_recruited_reason) : '-'))
            ->line('<strong>Tipo da lead: </strong>' . $this->recruitmentForm->type)
            ->line('<strong>Canal: </strong>' . $this->recruitmentForm->chanel)
            ->line('<strong>Horario: </strong>' . $this->recruitmentForm->daytime)
            ->action('Curriculum vitae', url($this->recruitmentForm->cv && $this->recruitmentForm->cv->original_url ? $this->recruitmentForm->cv->original_url : ''))
            ->line('Obrigado por utilizar os servicos da Expertcom!');
    }

    public function toArray($notifiable)
    {
        return [];
    }
}