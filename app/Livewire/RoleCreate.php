<?php

namespace App\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Permission;

class RoleCreate extends Component
{
    public $permissionsGrouped;
    public $name;
    public $permissions=[];
    public $allPermissions;
    public $selectAll = false;
    public function mount()
    {
        if(!auth()->user()->can('role.create')) {
            return abort(403, 'Unauthorized action.');
        }
        $permissions = Permission::all();

        $this->allPermissions = $permissions;
        $grouped = collect($permissions)
            ->map(function ($item) {
                $item->group_name = explode('.', $item->name)[0]; // add new field
                return $item;
            })
            ->groupBy('group_name');
        $this->permissionsGrouped = $grouped;
        // dd($this->permissionsGrouped);
    }
    public function updatedSelectAll()
    {
        if($this->selectAll){
            $this->permissions = $this->allPermissions->pluck('name')->toArray();
        }
        if(!$this->selectAll){
            $this->permissions = [];
        }
    }
    public function render()
    {
        return view('livewire.role-create')->layout('layouts.company');
    }
    public function save()
    {
        $this->validate([
            'name' => 'required|unique:roles,name',
        ]);
        // dd($this->permissions);
        $role = \Spatie\Permission\Models\Role::create(['name' => $this->name]);
        $role->syncPermissions($this->permissions);
        return redirect()->route('company.roles.list')->with('success', 'Role created successfully.');
    }
}
