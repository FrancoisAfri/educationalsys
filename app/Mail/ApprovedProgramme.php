<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Storage;

class ApprovedProgramme extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $user;
    public $programme_url = '/education/programme/';
    
    public function __construct(User $user, $programme_id)
    {
        $this->user = $user->load('person');
        $this->programme_url .= $programme_id.'/view';
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
        $fromName = 'osizweni Support';
        $subject = 'Programme Approved | Osizweni Education & Development Centre';

        $data['support_email'] = 'support@osizweni.org.za';
        $data['company_name'] = 'Osizweni Education & Development Centre';
        $data['company_logo'] = 'http://osizweni.afrixcel.org.za' . Storage::disk('local')->url('logos/logo.png');

        return $this->view('mails.approved_programme')
            ->from($fromAddress, $fromName)
            ->subject($subject)
            ->with($data);
    }
}
