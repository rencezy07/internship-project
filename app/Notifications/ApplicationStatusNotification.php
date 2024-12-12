<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ApplicationStatusNotification extends Notification
{
    use Queueable;

    protected $status;
    protected $internshipName;
    protected $companyName;

    public function __construct($status, $internshipName, $companyName)
    {
        $this->status = $status;
        $this->internshipName = $internshipName;
        $this->companyName = $companyName;
    }

    public function via($notifiable)
    {
        return ['database']; // Store notification in the database
    }

    public function toArray($notifiable)
    {
        return [
            'message' => $this->getMessage(),
        ];
    }

    private function getMessage()
    {
        switch ($this->status) {
            case 'accepted':
                return "Your application for the internship '{$this->internshipName}' at '{$this->companyName}' has been accepted.";
            case 'rejected':
                return "Your application for the internship '{$this->internshipName}' at '{$this->companyName}' has been rejected.";
            default:
                return "Your application for the internship '{$this->internshipName}' at '{$this->companyName}' is under review.";
        }
    }
}
