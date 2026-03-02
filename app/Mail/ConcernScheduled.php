<?php

namespace App\Mail;

use App\Models\Concern;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ConcernScheduled extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Concern $concern) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Concern Has Been Scheduled — ' . config('app.name'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.concern_scheduled',
        );
    }
}
