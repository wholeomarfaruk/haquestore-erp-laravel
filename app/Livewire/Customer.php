<?php

namespace App\Livewire;

use App\Models\Customer as ModelsCustomer;
use Livewire\Component;
use Livewire\WithPagination;

class Customer extends Component
{
    public $customers;
    public $viewModal = false;
    public $customer;
    public $status;
    public $registerModal = false;
    public $editModal = false;
    public $updateBalanceModal = false;
    public $newCustomerName, $newCustomerPhone, $newCustomerSecondPhone, $newCustomerEmail, $newCustomerAddress, $newCustomerStatus, $newCustomerNote;
    public $editCustomerName, $editCustomerPhone, $editCustomerSecondPhone, $editCustomerEmail, $editCustomerAddress, $editCustomerStatus, $editCustomerNote, $editCustomerId;
    public $search = '';
    public $currentBalance = 0.00;
    public $amount;
    public $balupdateNote;
    public $balupdateAction;
    public $DeletUserModal = false;

    use WithPagination;

    protected $paginationTheme = 'tailwind'; // or 'tailwind'

    public function mount()
    {

        //    dd($this->users->first()->roles());

    }
    public function updatedStatus($value)
    {
        $this->status = $value;


        $customer = $this->customer;
        if ($customer) {
            $customer->status = $value;
            $customer->save();
        }
    }


    public function render()
    {

        if (!empty($this->search)) {
            // dd($this->search);
            $this->customers = ModelsCustomer::where('name', 'LIKE', '%' . $this->search . '%')
                ->orWhere('phone', 'LIKE', '%' . $this->search . '%')
                ->orWhere('second_phone', 'LIKE', '%' . $this->search . '%')
                ->orWhere('email', 'LIKE', '%' . $this->search . '%')
                ->get();
        } else {

            $this->customers = ModelsCustomer::all();

        }
        return view('livewire.customer')->layout('layouts.company');
    }
    public function deleteCustomer($id)
    {
        $customer = ModelsCustomer::find($id);
        if (!$customer) {
            return abort(404);
        }
        if (file_exists($customer->image)) {
            unlink($customer->image);
        }
        $customer->delete();
        $this->DeletUserModal = false;
        $this->dispatch('toast', [
            'type' => 'success',
            'message' => 'Customer deleted successfully!'
        ]);
    }
    public function deleteCustomerConfirm($id)
    {
        $this->customer = ModelsCustomer::find($id);
        $this->DeletUserModal = true;
    }
    public function viewCustomer($id)
    {
        $customer = ModelsCustomer::find($id);
        if (!$customer) {
            return abort(404);
        }
        $this->customer = $customer;
        $this->status = $customer->status;
        $this->viewModal = true;
    }
    public function registerCustomer()
    {
        $this->validate([
            'newCustomerName' => 'required|min:3',
            'newCustomerPhone' => 'min:11|max:11|unique:customers,phone',
        ]);
        try {
            //code...


            $customer = new ModelsCustomer();
            $customer->name = $this->newCustomerName;
            $customer->phone = $this->newCustomerPhone;
            if ($this->newCustomerSecondPhone) {
                $customer->second_phone = $this->newCustomerSecondPhone;
            }
            if ($this->newCustomerEmail) {
                $customer->email = $this->newCustomerEmail;
            }
            if ($this->newCustomerAddress) {
                $customer->address = $this->newCustomerAddress;
            }
            if ($this->newCustomerStatus) {
                $customer->status = $this->newCustomerStatus;
            }
            if ($this->newCustomerNote) {
                $customer->note = $this->newCustomerNote;
            }
            $customer->save();
            $this->customers = ModelsCustomer::all();
            $this->registerModal = false;
        $this->reset([
            'newCustomerName',
            'newCustomerPhone',
            'newCustomerSecondPhone',
            'newCustomerEmail',
            'newCustomerAddress',
            'newCustomerNote',
        ]);
        $this->dispatch('toast', [
            'type' => 'success',
            'message' => 'Customer created successfully'
        ]);
        } catch (\Throwable $th) {
            //throw $th;
        // dd($th->getMessage());

        $this->dispatch('toast', [
            'type' => 'error',
            'message' => 'Something went wrong!'
        ]);
        }
    }
    public function updateCustomerModal($id)
    {
        $customer = ModelsCustomer::find($id);
        if (!$customer) {
            return abort(404);
        }
        $this->customer = $customer;
        $this->editCustomerId = $customer->id;
        $this->editCustomerName = $customer->name;
        $this->editCustomerPhone = $customer->phone;
        $this->editCustomerSecondPhone = $customer->second_phone;
        $this->editCustomerEmail = $customer->email;
        $this->editCustomerAddress = $customer->address;
        $this->editCustomerStatus = $customer->status;
        $this->editCustomerNote = $customer->note;
        $this->editModal = true;
    }
    public function getCustomerBal($id)
    {
        $customer = ModelsCustomer::find($id);
        if (!$customer) {
            return abort(404);
        }
        $this->customer = $customer;
        $this->editCustomerName = $customer->name;
        $this->currentBalance = $customer->balance;
        $this->editCustomerId = $customer->id;


        $this->updateBalanceModal = true;
    }
    public function updateBalance()
    {
        // dd($this->editCustomerId);
        $this->validate([
            'amount' => 'required',
            'balupdateAction' => 'required',
        ]);
        $id = $this->editCustomerId;
        if (!$id) {
            return;
        }
        $customer = ModelsCustomer::find($id);
        if (!$customer) {
            return abort(404);
        }
        $this->customer = $customer;

        if ($this->balupdateAction == 'credit' && $this->amount) {
            $customer->balance = $customer->balance + $this->amount;
        }
        if ($this->balupdateAction == 'debit' && $this->amount) {
            $customer->balance = $customer->balance - $this->amount;
        }
        $customer->save();
        $this->customers = ModelsCustomer::all();
        $this->updateBalanceModal = false;
        $this->reset(['amount', 'balupdateAction']);
    }
    public function updateCustomer()
    {
        if (!$this->editCustomerId) {
            return;
        }
        $id = $this->editCustomerId;

        $customer = ModelsCustomer::find($id);

        $this->validate([
            'editCustomerName' => 'required|min:3',
            'editCustomerPhone' => 'min:11',
        ]);

        if (!$customer) {
            return;
        }
        $customer->name = $this->editCustomerName;
        $customer->phone = $this->editCustomerPhone;
        $customer->second_phone = $this->editCustomerSecondPhone;
        $customer->email = $this->editCustomerEmail;
        $customer->address = $this->editCustomerAddress;
        $customer->status = $this->editCustomerStatus;
        $customer->note = $this->editCustomerNote;

        $customer->save();
        $this->customers = ModelsCustomer::all();
        $this->editModal = false;
        $this->dispatch('toast', [
            'type' => 'success',
            'message' => 'Customer updated successfully!'
        ]);
    }
}

