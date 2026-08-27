<?php

namespace Tests\Feature;

use App\Mail\ContactMessageMail;
use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_message_is_stored_and_mailed_to_the_store_inbox(): void
    {
        Mail::fake();

        SiteSetting::create([
            'site_name' => 'مكتبة ابن تيمية',
            'contact_email' => 'admin@store.local',
        ]);

        $this->post(route('contact.store'), [
            'name' => 'خالد',
            'email' => 'khaled@test.local',
            'phone' => '0790000000',
            'subject' => 'استفسار عن كتاب',
            'message' => 'هل يتوفر شرح العقيدة الطحاوية؟',
        ])->assertRedirect();

        $this->assertDatabaseHas('contacts', ['email' => 'khaled@test.local']);

        Mail::assertQueued(ContactMessageMail::class, function ($mail) {
            return $mail->hasTo('admin@store.local')
                && $mail->hasReplyTo('khaled@test.local');
        });
    }

    public function test_contact_mail_renders_message_content(): void
    {
        SiteSetting::create(['site_name' => 'Store', 'contact_email' => 'admin@store.local']);

        $this->post(route('contact.store'), [
            'name' => 'Khaled',
            'email' => 'khaled@test.local',
            'subject' => 'Book inquiry',
            'message' => 'Is Sharh At-Tahawiyyah available?',
        ])->assertRedirect();

        $contact = \App\Models\Contact::first();
        $html = (new ContactMessageMail($contact, 'Store'))->render();

        $this->assertStringContainsString('Book inquiry', $html);
        $this->assertStringContainsString('Is Sharh At-Tahawiyyah available?', $html);
        $this->assertStringContainsString('khaled@test.local', $html);
    }
}
