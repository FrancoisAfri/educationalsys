<?php

namespace App\Mail;

use App\HRPerson;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Storage;

class ProgrammeGMApproval extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $person;
    public $programme_url = '/education/programme/';

    public function __construct(HRPerson $person, $programme_id)
    {
        $this->person = $person;
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
        $subject = 'Approval Needed | Osizweni Education & Development Centre';

        $data['support_email'] = 'support@osizweni.org.za';
        $data['company_name'] = 'Osizweni Education & Development Centre';
        $data['company_logo'] = url('/') . Storage::disk('local')->url('logos/logo.png');

        return $this->view('mails.programme_gm_approval')
            ->from($fromAddress, $fromName)
            ->subject($subject)
            ->with($data);
    }
}
