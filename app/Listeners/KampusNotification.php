<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\KampusSaved;
use Mail;

class KampusNotification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\KampusSaved $event
     * @return void
     */
    public function handle(KampusSaved $event)
    {
        // Access the kampus using $event->kampus...
        //$vKampus = \App\Models\Kampus::find($event->kampus->id)->toArray();

        Mail::send('emails.kampus.registered', [
            'title' => trans('email.subject.new_kampus'),
            'nama_kampus' => $event->additionalArray['nama_kampus'],
            'email' => $event->additionalArray['email'],
            'phone' => $event->additionalArray['phone'],
            'apitoken' => $event->additionalArray['api_token']
        ], function ($message) use ($event) {
            $message->from(env('MAIL_FROM_ADDRESS'), "admin@skeletonlaravel.com");
            $message->to($event->additionalArray['email']);
            $message->subject(trans('email.subject.new_kampus'));
        });
    }

    /**
     * Handle a job failure.
     *
     * @param \App\Events\KampusSaved $event
     * @param  \Exception $exception
     * @return void
     */
    public function failed(KampusSaved $event, $exception)
    {
        //
    }
}