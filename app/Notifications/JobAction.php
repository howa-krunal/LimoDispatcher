<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Carbon\Carbon;

class JobAction extends Notification
{
    use Queueable;
    protected $jobId;
    protected $jobBooking;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($jobData)
    {
        $this->jobId = $jobData->id;
        $this->jobBooking = $jobData->booking_no;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'changeTime'=> Carbon::now(),
            'jobId'=> $this->jobId,
            'jobBooking'=> $this->jobBooking
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
