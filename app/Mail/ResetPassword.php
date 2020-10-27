<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Storage;

class ResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $user;
    public $generated_pw;

    public function __construct(User $user, $randomPass)
    {
        $this->user = $user->load('person');
        $this->generated_pw = $randomPass;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //Should get these details from setup
        $fromAddress = 'noreply@osizweni.org.za';
        $fromName = 'Osizweni Support';
        $subject = 'Password Reset | NU-LAXMI LEASING';

        $data['support_email'] = 'support@osizweni.org.za';
        $data['company_name'] = 'NU-LAXMI LEASING';
        $data['company_logo'] = url('/') . Storage::disk('local')->url('logos/logo.png');
        $data['profile_url'] = 'http://devloans.osizweni.org.za/users/profile';

        return $this->view('mails.reset_password')
            ->from($fromAddress, $fromName)
            ->subject($subject)
            ->with($data);
    }
}
