<?php
namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomPasswordReset extends ResetPassword 

{
    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;

    /**
     * Create a notification instance.
     *
     * @param  string  $token
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
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

    // public $from = ;

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url   = $_SERVER['SERVER_NAME'] . '/password/reset/' . $this->token;
        $title = "AfricanLand password Reset";
        return (new MailMessage)
            ->subject('AfricanLand password Reset')
            ->from('no-reply@afriacanland.com', 'Afriacan Land')
            ->view('emails.passwordReset', compact('url', 'title'));
    }
}
