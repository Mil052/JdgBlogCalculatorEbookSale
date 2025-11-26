<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactUs;

new class extends Component {
    #[Validate('required|min:6')]
    public $messageTitle;
    #[Validate('required|email:rfc,dns')]
    public $emailAddress;
    #[Validate('required|min:6')]
    public $userName;
    #[Validate('required|min:6')]
    public $messageContent;

    public $messageSent = false;

    public function sendEmailMessage()
    {
        $this->validate();
        // send email
        Mail::to('7arh3ad@gmail.com')->send(
            new ContactUs(
                $this->messageTitle,
                $this->messageContent,
                $this->userName,
                $this->emailAddress
            )
        );
        // reset form
        $this->messageTitle = "";
        $this->emailAddress = "";
        $this->userName = "";
        $this->messageContent = "";

        $this->messageSent = true;
    }
}; ?>

<div class="bg-light-blue px-4 xs:px-8 py-8 relative rounded-sm">
    <h3 class="font-paragraph text-coffee text-3xl text-center">Napisz do nas</h3>
    <form wire:submit="sendEmailMessage">
        <div class="flex flex-col gap-1 my-4">
            <label for="contact-title" class="label">Temat</label>
            <input type="text" id="contact-title" wire:model="messageTitle" class="input-secondary text-coffee">
            <div>
                @error('messageTitle')
                    <span class="text-red-brick text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="flex flex-col gap-1 my-4">
            <label for="contact-email" class="label">Twój adres e-mail</label>
            <input type="email" id="contact-email" wire:model="emailAddress" class="input-secondary">
            <div>
                @error('emailAddress')
                    <span class="text-red-brick text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="flex flex-col gap-1 my-4">
            <label for="contact-user-name" class="label">Imię i nazwisko</label>
            <input type="text" id="contact-user-name" wire:model="userName" class="input-secondary">
            <div>
                @error('userName')
                    <span class="text-red-brick text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="flex flex-col gap-1 my-4">
            <label for="contact-message" class="label">Treść wiadomości</label>
            <textarea id="contact-message" wire:model="messageContent" class="input-secondary" rows="9"></textarea>
            <div>
                @error('messageContent')
                    <span class="text-red-brick text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div x-data="{openConfirmationWindow: false}" class="mt-6">
            <button type="button" x-show="!openConfirmationWindow" class="block btn-primary ml-auto" @click="openConfirmationWindow = true">
                Wyślij wiadomość
            </button>
            <div x-cloak x-show="openConfirmationWindow">
                <h4 class="paragraph-sm my-4">
                    Czy napewno chcesz wysłać wiadomość?
                </h4>
                <div class="flex justify-between">
                    <button type="button" class="btn-secondary" @click="openConfirmationWindow = false">
                        Anuluj
                    </button>
                    <button type="submit" class="btn-primary" @click="openConfirmationWindow = false">
                        Wyślij
                    </button>
                </div>
            </div>
        </div>
    </form>
    @if ($messageSent)
        <div x-show="$wire.messageSent" class="absolute top-0 left-0 bg-[#f4f4f4cc] w-full h-full p-8 flex flex-col justify-center z-20">
            <div class="bg-white shadow-[6px_6px_6px_#00000040] p-8 rounded-sm">
                <button type="button" class="block ml-auto" @click="$wire.messageSent = false">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1 1L23 23" stroke="black" stroke-width="1.5" stroke-linecap="round"/>
                        <path d="M23 1L1 23" stroke="black" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                </button>
                <h4 class="paragraph-sm my-8">
                    Twoja wiadomość została wysłana.
                </h4>
            </div>
        </div>
    @endif
</div>
