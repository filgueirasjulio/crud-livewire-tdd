<?php

namespace Tests\Feature\Contacts;

use Tests\TestCase;
use App\Models\User;
use Livewire\Livewire;
use App\Models\Contact;
use App\Http\Livewire\Contacts\ContactNew;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group contacts
 * @group contactCreate
 */
class ContactCreateTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function canCreateContact()
    {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());

        $contactFake = Contact::factory()->make();

        Livewire::test(ContactNew::class)
            ->call('mount', $contactFake)
            ->call('store')
            ->assertEmitted('created')
            ->assertEmitted('refreshList');

        $this->assertDatabaseHas('contacts', $contactFake->toArray());
    }

    /**
     * @test
     */
    public function cannotCreateInvalidEmailContact()
    {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());

        $contactFake = Contact::factory()->make(['email' => 'invalid']);

        Livewire::test(ContactNew::class)
            ->call('mount', $contactFake)
            ->call('store')
            ->assertHasErrors(['newContact.email' => 'email']);

    }

    /**
     * @test
     */
    public function checkRequiredFieldsCreateContact()
    {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());

        Livewire::test(ContactNew::class)
            ->call('store')
            ->assertHasErrors([
                'newContact.name' => 'required',
                'newContact.email' => 'required',
                'newContact.phone' => 'required',
                'newContact.message' => 'required'
            ]);

    }
}
