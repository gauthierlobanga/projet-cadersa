<?php

namespace Database\Factories;

use App\Models\Contact;
use App\Models\ContactReply;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ContactReply>
 */
class ContactReplyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'contact_id' => Contact::factory(),
            'user_id' => User::factory(),
            'recipient_email' => fake()->safeEmail(),
            'subject' => fake()->sentence(),
            'body' => fake()->paragraph(),
            'status' => ContactReply::STATUS_SENT,
            'sent_at' => now(),
            'failure_reason' => null,
        ];
    }
}
