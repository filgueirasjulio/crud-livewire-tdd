<?php

namespace Tests\Feature\Contacts;

use Tests\TestCase;
use App\Models\Team;
use App\Models\User;
use Livewire\Livewire;
use App\Models\Contact;
use App\Http\Livewire\Contacts\ContactItem;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group contacts
 * @group contactItem
 */
class ContactItemTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function canUpdateContact()
    {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());

        $contact = Contact::factory()
            ->create(['team_id' => $user->currentTeam->id]);

        $contact->name = 'update name';
        $contact->email = 'update@email.com';

        Livewire::test(ContactItem::class)
            ->call('edit', $contact)
            ->call('update')
            ->assertEmitted('refreshList');

        $this->assertDatabaseHas('contacts', [
            'name' => 'update name',
            'email' => 'update@email.com',
        ]);
    }

    /**
     * @test
     */
    public function canDestroyContact()
    {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());

        $contact = Contact::factory()->create();

        Livewire::test(ContactItem::class)
            ->call('confirmDeletion', $contact)
            ->call('destroy')
            ->assertEmitted('refreshList');

        $this->assertDatabaseMissing('contacts', $contact->getAttributes());
    }

    /**
     * @test
     */
    public function cannotDestroyNonTeamContact()
    {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());

        $contact = Contact::factory()
            ->create(['team_id' => Team::factory()]);

        Livewire::test(ContactItem::class)
            ->call('confirmDeletion', $contact)
            ->assertForbidden();

        $this->assertDatabaseHas('contacts', $contact->getAttributes());
    }
}