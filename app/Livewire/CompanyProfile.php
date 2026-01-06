<?php

namespace App\Livewire;

use App\Models\Company;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;


class CompanyProfile extends Component
{
    public $CompanyName;
    public $CompanyAddress;
    public $CompanyPhone;
    public $CompanySecondaryPhone;
    public $CompanyEmail;
    public $CompanyWebsite;
    public $CompanyLogo;
    public $CompanyDescription;
    public $CompanyLogoPath;
    use WithFileUploads;
    public function render()
    {
        if ($this->CompanyLogo) {
            $this->validate([
                'CompanyLogo' => 'image|mimes:jpeg,png,jpg|max:2048',
            ]);
        }

        $company = Company::first();

        $this->CompanyName = $company->name;
        $this->CompanyAddress = $company->address;
        $this->CompanyPhone = $company->phone;
        $this->CompanySecondaryPhone = $company->secondary_phone;
        $this->CompanyEmail = $company->email;
        $this->CompanyWebsite = $company->website;

        $this->CompanyLogoPath = asset('storage/' . $company->logo);
        $this->CompanyDescription = $company->description;
        return view('livewire.company-profile')->layout('layouts.company');
    }
    public function update()
    {
        $company = Company::first();
        $company->name = $this->CompanyName;
        $company->address = $this->CompanyAddress;
        $company->phone = $this->CompanyPhone;
        $company->secondary_phone = $this->CompanySecondaryPhone;
        $company->email = $this->CompanyEmail;
        $company->website = $this->CompanyWebsite;

        $company->description = $this->CompanyDescription;
        if ($this->CompanyLogo) {
            $oldpath = public_path('storage/' . $company->CompanyLogoPath);
            if ($company->CompanyLogoPath && is_file($oldpath)) {

                unlink($oldpath);
            }
            $path = public_path('storage/company');
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $filename = Str::uuid() . '.' . $this->CompanyLogo->getClientOriginalExtension();
            copy($this->CompanyLogo->getRealPath(), $path . '/' . $filename);

            $company->logo = "company/$filename";
        }
        $company->save();

        $this->dispatch('toast', [
            'type' => 'success',
            'message' => 'Company Profile Updated Successfully'
        ]);
    }
}
