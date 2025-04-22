<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\WithFileUploads;

class EditProfile extends Component
{
    use WithFileUploads;

    public $name;
    public $email;
    public $password;
    public $profile_photo;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'nullable|string|min:8',
            'profile_photo' => 'nullable|image|max:1024',
        ];
    }

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
    }

    public function save()
    {
        $this->validate();

        $user = Auth::user();
        $user->name = $this->name;
        $user->email = $this->email;

        if ($this->password) {
            $user->password = Hash::make($this->password);
        }

        if ($this->profile_photo) {
            $user->profile_photo = $this->profile_photo->store('profile_photos');
        }

        $user->save();
        session()->flash('message', 'Profile updated successfully!');
    }

    public function render()
    {
        return view('livewire.edit-profile');
    }
}
