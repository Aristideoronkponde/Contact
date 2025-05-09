<?php

namespace App\Events;

use App\Models\Contact;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ContactEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $contact;

    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('contacts'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'contact.created';
    }

    public function broadcastWith(): array
    {
       

        return [
            'message' => "Nouveau contact  : {$this->contact->name}  ajouté avec succès !", 
            'contact' => [
                'id' => $this->contact->id,
                'name' => $this->contact->name,
                'email' => $this->contact->email,
                'country' => $this->contact->country,
                'country_flag' => $this->contact->country_flag,
            ],
        ];
    }
}