<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class UserList extends Component
{
    public $users;
    public $viewModal = false;
    public $user;
    public $roles;
    public $role_name;
    public $UserModal = false;
    public $newUserName, $newUserEmail, $newUserPassword;
    public $search = '';
    public function mount()
    {
        $this->users = User::all();
        $this->roles = Role::all();
        //    dd($this->users->first()->roles());

    }
    public function updatedRoleName($value)
    {
        $this->role_name = $value;

        $user = $this->user;
        $user->syncRoles([$value]);


    }


    public function render()
    {

        if (!empty($this->search)) {
            // dd($this->search);
            $this->users = User::where('name', 'LIKE', '%' . $this->search . '%')
                ->orWhere('email', 'LIKE', '%' . $this->search . '%')
                ->get();
        } else {

            $this->users = User::all();
        }
        return view('livewire.user-list')->layout('layouts.company');
    }
    public function deleteUser($id)
    {
        $user = User::find($id);
        if (!$user) {
            return abort(404);
        }
        if($user->hasRole('superadmin')) {
              $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'Superadmin cannot be deleted'
            ]);
            return;
        }
        if (file_exists($user->profile_photo_path)) {
            unlink($user->profile_photo_path);
        }
        $user->delete();
        $this->users = User::all();
    }
    public function viewUser($id)
    {
        $user = User::find($id);
        if (!$user) {
            return abort(404);
        }
        $this->user = $user;
        $this->role_name = $user?->roles?->first()?->name;
        $this->viewModal = true;
    }
    public function registerUser()
    {
        $this->validate([
            'newUserName' => 'required|min:3',
            'newUserEmail' => 'required|email',
            'newUserPassword' => 'required|min:8',
        ]);
        $user = User::create([
            'name' => $this->newUserName,
            'email' => $this->newUserEmail,
            'password' => bcrypt($this->newUserPassword),
        ]);
        $this->users = User::all();
        $this->UserModal = false;
    }
}
