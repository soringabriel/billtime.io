<?php

namespace App\Domains\Auth\Notifications\Frontend;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Class TimeReport.
 */
class TimeReport extends Notification
{
    /**
     * Create a new invoice email instance
     *
     * @param  InvoiceService  $invoiceService
     * @param  file  $xls
     * @param  array $data
     *
     * @return void
     */
    public function __construct($xls, $data)
    {
        $this->total_hours = intval($data['total_hours']);
        $this->xls = $xls;
    }

    /**
     * Get the notification's channels.
     *
     * @param  mixed  $notifiable
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $mail = (new MailMessage)
            ->subject(__('Your weekly time report'))
            ->line(__('Over the past week you recorded') . ' ' . $this->total_hours . ' ' . __('hours, using billtime.io'));

        if (!is_null($this->xls)) {
            $mail->line(__('You will find a detailed report with the recorded time, attached to this email'));
        } else {
            $mail->line(__('Don\'t forget to track your time!'));
        }

        $mail->action(__('Go to BillTime.io'), 'https://billtime.io');
        
        if (!is_null($this->xls)) {
            $mail->attachData($this->xls, "time_records.xls", [
                'mime' => 'application/vnd.ms-excel',
            ]);
        }   
        return $mail;
    }
}
