   {{-- ======================== Page Layout Start From Here ======================== --}}

   <div x-data x-init="$store.pageName = { name: 'Manage Company Profile', slug: 'company' }">
       {{-- ======================== Page Header Start From Here ======================== --}}
       <div class="flex flex-wrap justify-between gap-6 ">
           {{-- Page Name  --}}
           <h1 class="text-gray-500 text-lg font-bold" x-cloak x-text="$store.pageName?.name ?? ''">
           </h1>
           {{-- Breadcrumb  --}}
           <nav>
               <ol class="flex items-center gap-1.5">
                   <li>
                       <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400"
                           href="{{ route('company.dashboard') }}">
                           Dashboard
                           <svg class="stroke-current" width="17" height="16" xmlns="http://www.w3.org/2000/svg"
                               fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                               class="size-6">
                               <path stroke-linecap="round" stroke-linejoin="round"
                                   d="m5.25 4.5 7.5 7.5-7.5 7.5m6-15 7.5 7.5-7.5 7.5" />
                           </svg>

                       </a>
                   </li>
                   <li class="text-sm text-gray-800 dark:text-white/90" x-text="$store.pageName?.name ?? ''"></li>
               </ol>
           </nav>
       </div>
       {{-- ======================== Page Header End Here ======================== --}}

       <div class="flex-1 w-full bg-white rounded-lg min-h-[80vh]">
           {{-- ======================== Content Start From Here ======================== --}}
           <div class="mt-4 p-4 max-w-xl mx-auto">

               <form class="space-y-4" wire:submit.prevent="registerCustomer">
                   <div class="grid grid-cols-1 gap-1">
                       <label class="block text-sm font-medium text-gray-900" for="name">Company Name</label>
                       <input wire:model="CompanyName"
                           class="mt-1 w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:outline-none p-2"
                           id="name" type="text" placeholder="Enter Name" />
                       @error('CompanyName')
                           <span class="text-red-500">{{ $message }}</span>
                       @enderror
                   </div>

                   <div class="grid grid-cols-1 gap-1">
                       <label class="block text-sm font-medium text-gray-900" for="phone">Phone</label>
                       <input wire:model="CompanyPhone"
                           class="mt-1 w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:outline-none p-2"
                           id="phone" type="text" placeholder="Enter Phone Number" />
                       @error('CompanyPhone')
                           <span class="text-red-500">{{ $message }}</span>
                       @enderror
                   </div>
                   <div class="grid grid-cols-1 gap-1">
                       <label class="block text-sm font-medium text-gray-900" for="company_address">Secondary
                           Phone
                       </label>
                       <input wire:model="CompanySecondaryPhone"
                           class="mt-1 w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:outline-none p-2"
                           id="company_address" type="text" placeholder="Enter secondary phone" />
                       @error('CompanySecondaryPhone')
                           <span class="text-red-500">{{ $message }}</span>
                       @enderror
                   </div>
                   <div class="grid grid-cols-1 gap-1">
                       <label class="block text-sm font-medium text-gray-900" for="email">Email</label>
                       <input wire:model="CompanyEmail"
                           class="mt-1 w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:outline-none p-2"
                           id="email" type="email" placeholder="Enter Email" />
                       @error('CompanyEmail')
                           <span class="text-red-500">{{ $message }}</span>
                       @enderror
                   </div>
                   <div>
                       <label class="block text-sm font-medium text-gray-900" for="address">Address</label>


                       <textarea wire:model="CompanyAddress"
                           class="mt-1 w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:outline-none p-2" id="address"
                           rows="4" placeholder="Enter Address"></textarea>
                       @error('CompanyAddress')
                           <span class="text-red-500">{{ $message }}</span>
                       @enderror
                   </div>
                   <div>
                       <label class="block text-sm font-medium text-gray-900" for="note">Note</label>

                       <textarea wire:model="CompanyDescription"
                           class="mt-1 w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:outline-none p-2" id="note"
                           rows="4" placeholder="Enter Note"></textarea>
                       @error('CompanyDescription')
                           <span class="text-red-500">{{ $message }}</span>
                       @enderror
                   </div>
                        <div class="flex flex-row gap-1 mt-2" wire:key="new-product-image-container">
                           @if (isset($CompanyLogo) && $CompanyLogo->temporaryUrl())
                               <div class="grid grid-cols-1 gap-1 flex-1">
                                   <div class="w-full">
                                       <img src="{{ $CompanyLogo?->temporaryUrl() }}" alt="Company Logo"
                                           class="w-full h-auto rounded-lg shadow-sm">
                                   </div>
                               </div>
                               @elseif (isset($CompanyLogo) && !$CompanyLogo->temporaryUrl())
                               <div class="grid grid-cols-1 gap-1 flex-1">
                                   <div class="w-full">
                                       <img src="{{ asset('storage/' . $CompanyLogo) }}" alt="Company Logo"
                                           class="w-full h-auto rounded-lg shadow-sm">
                                   </div>
                               </div>
                           @endif
                           <div class="grid grid-cols-1 gap-1 flex-1 ">
                               <label for="NewFile"
                                   class="flex flex-col items-center rounded-lg border border-gray-300 p-4 text-gray-900 shadow-sm sm:p-6">
                                   <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                       stroke-width="1.5" stroke="currentColor" class="size-6">
                                       <path stroke-linecap="round" stroke-linejoin="round"
                                           d="M7.5 7.5h-.75A2.25 2.25 0 0 0 4.5 9.75v7.5a2.25 2.25 0 0 0 2.25 2.25h7.5a2.25 2.25 0 0 0 2.25-2.25v-7.5a2.25 2.25 0 0 0-2.25-2.25h-.75m0-3-3-3m0 0-3 3m3-3v11.25m6-2.25h.75a2.25 2.25 0 0 1 2.25 2.25v7.5a2.25 2.25 0 0 1-2.25 2.25h-7.5a2.25 2.25 0 0 1-2.25-2.25v-.75">
                                       </path>
                                   </svg>

                                   <span class="mt-4 font-medium"> Upload Logo <span
                                           class="size-6 text-red-500 mr-1.5">*</span> </span>

                                   <span
                                       class="mt-2 inline-block rounded border border-gray-200 bg-gray-50 px-3 py-1.5 text-center text-xs font-medium text-gray-700 shadow-sm hover:bg-gray-100">
                                       Browse file
                                   </span>
                                   @error('CompanyLogo')
                                       <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                   @enderror

                                   <input wire:key="new-product-image" wire:model.live="CompanyLogo" type="file"
                                       id="NewFile" class="sr-only">
                               </label>
                           </div>
                       </div>

                   <button type="submit"
                       class="block w-full rounded-lg border border-indigo-600 bg-white px-12 py-3 text-sm font-medium text-indigo-600 transition-colors hover:bg-indigo-500 hover:text-white cursor-pointer">
                       Submit
                   </button>
               </form>

           </div>


           {{-- =========================== Content End Here ============================ --}}
       </div>

   </div>


   {{-- =========================== Page Layout End Here ============================ --}}
