<?php

namespace App\Services;

use App\Mail\ContactReplyMail;
use App\Models\Contact;
use App\Models\ContactReply;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Throwable;

class ContactReplyService
{
    public function send(Contact $contact, User $user, string $subject, string $body, bool $includeOriginal): ContactReply
    {
        $reply = $contact->replies()->create([
            'user_id' => $user->getKey(),
            'recipient_email' => $contact->email,
            'subject' => $subject,
            'body' => $body,
            'status' => ContactReply::STATUS_SENDING,
        ]);

        try {
            Mail::to($contact->email)->send(new ContactReplyMail(
                recipientName: $contact->full_name,
                recipientEmail: $contact->email,
                replySubject: $subject,
                response: $body,
                originalSubject: $contact->sujet,
                originalMessage: $contact->message,
                includeOriginal: $includeOriginal,
            ));

            $reply->forceFill([
                'status' => ContactReply::STATUS_SENT,
                'sent_at' => now(),
            ])->save();

            $contact->marquerRepondu($user, $body);
        } catch (Throwable $exception) {
            report($exception);

            $reply->forceFill([
                'status' => ContactReply::STATUS_FAILED,
                'failure_reason' => Str::limit($exception->getMessage(), 2000),
            ])->save();
        }

        return $reply;
    }
}
