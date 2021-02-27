<?php

namespace App\Http\Livewire\Contacts;

use App\Models\Contact;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class ContactItem extends Component
{
    use AuthorizesRequests;

    public Contact $contact;
    public bool $updating;
    public bool $destroying;
    
    /**
     * edit
     *
     * @param  mixed $contact
     * @return void
     */
    public function edit(Contact $contact)
    {
        $this->authorize('update', $contact);

        $this->clearValidation();

        $this->updating = true;

        $this->contact = $contact;
    }
    
    /**
     * update
     *
     * @return void
     */
    public function update()
    {
        $this->validate();

        $this->contact->save();

        $this->updating = false;

        $this->emit('refreshList');
    }
        
    /**
     * confirmDeletion
     *
     * @param  mixed $contact
     * @return void
     */
    public function confirmDeletion(Contact $contact)
    {
        $this->authorize('delete', $contact);

        $this->destroying = true;

        $this->contact = $contact;
    }
    
    /**
     * destroy
     *
     * @return void
     */
    public function destroy()
    {
        $this->contact->delete();

        $this->destroying = false;

        $this->emit('refreshList');
    }
    
    /**
     * render
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.contacts.item');
    }
    
    /**
     * rules
     *
     * @return void
     */
    protected function rules()
    {
        return [
            'contact.name' => 'required|string',
            'contact.email' => 'required|email',
            'contact.phone' => 'required|string|min:8',
            'contact.message' => 'required|string|min:10',
        ];
    }
}
