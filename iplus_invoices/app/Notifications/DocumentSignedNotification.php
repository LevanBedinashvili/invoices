<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DocumentSignedNotification extends Notification
{
    use Queueable;

    private $document;
    private $type;
    private $pdf;

    public function __construct($document, $type, $pdf)
    {
        $this->document = $document;
        $this->type = $type;
        $this->pdf = $pdf;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $subject = $this->type === 'warranty' ? 'თქვენი საგარანტიო დოკუმენტი' : 'თქვენი ინვოისი';
        $message = $this->type === 'warranty' ? 
            'თქვენ ხელი მოაწერეთ საგარანტიო დოკუმენტს. დოკუმენტი თან ერთვის.' :
            'თქვენ ხელი მოაწერეთ ინვოისს. დოკუმენტი თან ერთვის.';

        return (new MailMessage)
            ->subject($subject)
            ->line($message)
            ->line('მადლობა ჩვენი სერვისით სარგებლობისთვის.')
            ->attachData($this->pdf->output(), $this->getFilename());
    }

    private function getFilename()
    {
        $prefix = $this->type === 'warranty' ? 'warranty' : 'invoice';
        $name = $this->document->signed_name ?? $this->document->first_name ?? 'user';
        $surname = $this->document->signed_surname ?? $this->document->last_name ?? 'user';
        $identifier = $this->type === 'warranty' ? 
            ($this->document->device_name ?? 'device') : 
            ($this->document->invoice_number ?? date('Y-m-d'));

        return sprintf('%s_%s_%s_%s.pdf', $prefix, $name, $surname, $identifier);
    }
}
