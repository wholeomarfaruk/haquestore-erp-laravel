   {{-- ======================== Page Layout Start From Here ======================== --}}
   @push('styles')
       <style>
           .swiper-button-prev,
           .swiper-button-next {
               width: 20px;
               height: 20px;
           }
       </style>
   @endpush
   <div x-data x-init="$store.pageName = { name: 'Manage Customers', slug: 'customers' }">
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
           <div class="grid grid-cols-2 gap-4 px-4 py-4 ">
               <div>
                   <label for="Search">
                       {{-- <span class="text-sm font-medium text-gray-700"> Search </span> --}}

                       <div class="relative">
                           <input type="text" wire:model.live.debounce="search" id="Search"
                               placeholder="Search by Name, Phone,Email"
                               class="mt-0.5 w-full rounded border-gray-300 px-2 py-2 shadow-sm sm:text-sm">

                           <span class="absolute inset-y-0 right-2 grid w-8 place-content-center">
                               <button type="button" aria-label="Submit"
                                   class="rounded-full p-1.5 text-gray-700 transition-colors hover:bg-gray-100">
                                   <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                       stroke-width="1.5" stroke="currentColor" class="size-4">
                                       <path stroke-linecap="round" stroke-linejoin="round"
                                           d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z">
                                       </path>
                                   </svg>
                               </button>
                           </span>
                       </div>
                   </label>
               </div>
               <div>
                   <div class="flex gap-4 sm:gap-6 justify-end items-end mt-2">
                       {{-- <details class="group relative">
                           <summary
                               class="flex items-center gap-2 border-b border-gray-300 pb-1 text-gray-700 transition-colors hover:border-gray-400 cursor-pointer hover:text-gray-900 [&amp;::-webkit-details-marker]:hidden ">
                               <span class="text-sm font-medium"> Filter </span>

                               <span class="transition-transform group-open:-rotate-180">
                                   <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                       stroke-width="1.5" stroke="currentColor" class="size-4">
                                       <path stroke-linecap="round" stroke-linejoin="round"
                                           d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path>
                                   </svg>
                               </span>
                           </summary>

                           <div
                               class="z-auto w-64 divide-y divide-gray-300 rounded border border-gray-300 bg-white shadow-sm group-open:absolute group-open:end-0 group-open:top-8">
                               <div class="flex items-center justify-between px-3 py-2">
                                   <span class="text-sm text-gray-700"> 0 Selected </span>

                                   <button type="button"
                                       class="text-sm text-gray-700 underline transition-colors hover:text-gray-900">
                                       Reset
                                   </button>
                               </div>

                               <fieldset class="">
                                   <legend class="sr-only">Checkboxes</legend>

                                   <div class="flex flex-col items-start gap-3">
                                       <label for="Option1" class="inline-flex items-center gap-3">
                                           <input type="checkbox" class="size-5 rounded border-gray-300 shadow-sm"
                                               id="Option1">

                                           <span class="text-sm font-medium text-gray-700"> Option 1 </span>
                                       </label>

                                       <label for="Option2" class="inline-flex items-center gap-3">
                                           <input type="checkbox" class="size-5 rounded border-gray-300 shadow-sm"
                                               id="Option2">

                                           <span class="text-sm font-medium text-gray-700"> Option 2 </span>
                                       </label>

                                       <label for="Option3" class="inline-flex items-center gap-3">
                                           <input type="checkbox" class="size-5 rounded border-gray-300 shadow-sm"
                                               id="Option3">

                                           <span class="text-sm font-medium text-gray-700"> Option 3 </span>
                                       </label>
                                   </div>
                               </fieldset>
                           </div>
                       </details> --}}
                       <div class="group">
                           <button wire:click="registerModal=true" type="button"
                               class="flex items-center gap-2  pb-1 text-gray-700 transition-colors hover:border-gray-400 hover:text-gray-900 cursor-pointer rounded border border-gray-300 px-4 py-2">
                               <span class="text-sm font-medium"> Add Customer</span>
                       </div>
                   </div>
               </div>
           </div>

           <div class="overflow-x-auto rounded border border-gray-300 shadow-sm mx-4">
               <table class="min-w-full divide-y-2 divide-gray-200">
                   <thead class="ltr:text-left rtl:text-right">
                       <tr class="*:font-medium *:text-gray-900">
                           <th class="px-3 py-2 whitespace-nowrap">Name</th>

                           <th class="px-3 py-2 whitespace-nowrap">Balance</th>
                           <th class="px-3 py-2 whitespace-nowrap">Status</th>
                           <th class="px-3 py-2 whitespace-nowrap">Address</th>
                           <th class="px-3 py-2 whitespace-nowrap text-center">Action</th>
                       </tr>
                   </thead>

                   <tbody class="divide-y divide-gray-200">
                       @if ($customers->count() >= 1)


                           @foreach ($customers as $customerItem)
                               <tr class="*:text-gray-900 *:first:font-medium">
                                   <td class="px-3 py-2 whitespace-nowrap flex justify-start gap-2 items-center">
                                       <div class=" sm:shrink-0">
                                           <img alt=""
                                               src="{{ $customerItem->profile_picture }}"
                                               class="size-12 rounded-full object-cover sm:size-[52px]">
                                       </div>
                                       <div>
                                           <p class="font-bold mb-0 text-sm/2">{{ $customerItem->name }}</p>
                                           <span class="text-xs text-gray-400">{{ $customerItem->phone }}</span>
                                       </div>
                                   </td>


                                   <td class="px-3 py-2 whitespace-nowrap">

                                       @if ($customerItem?->invoices?->last()?->due_amount <= 0)
                                           <span
                                               class="inline-flex items-center justify-center rounded-full bg-emerald-100 px-2.5 py-0.5 text-emerald-700 dark:bg-emerald-700 dark:text-emerald-100">

                                               <svg xmlns="http://www.w3.org/2000/svg" class="size-6 -ms-1 me-1.5"
                                                   fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                   stroke="currentColor" class="size-6">
                                                   <path stroke-linecap="round" stroke-linejoin="round"
                                                       d="m8.25 7.5.415-.207a.75.75 0 0 1 1.085.67V10.5m0 0h6m-6 0h-1.5m1.5 0v5.438c0 .354.161.697.473.865a3.751 3.751 0 0 0 5.452-2.553c.083-.409-.263-.75-.68-.75h-.745M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                               </svg>

                                               <p class="text-sm whitespace-nowrap">
                                                   {{ $customerItem?->invoices?->last()?->due_amount ?? '0.00' }}</p>
                                               {{-- <button wire:click="getCustomerBal({{ $customerItem->id }})"
                                                   class="cursor-pointer">
                                                   <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-1 ml-2"
                                                       fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                       stroke="currentColor">
                                                       <path stroke-linecap="round" stroke-linejoin="round"
                                                           d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                   </svg>

                                               </button> --}}
                                           </span>
                                       @elseif($customerItem?->invoices?->last()?->due_amount > 0)
                                           <span
                                               class="inline-flex items-center justify-center rounded-full bg-red-100 px-2.5 py-0.5 text-red-700 dark:bg-red-700 dark:text-red-100">
                                               <svg xmlns="http://www.w3.org/2000/svg" class="size-4 ml-1 mr-1.5"
                                                   fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                   stroke="currentColor">
                                                   <path stroke-linecap="round" stroke-linejoin="round"
                                                       d="m8.25 7.5.415-.207a.75.75 0 0 1 1.085.67V10.5m0 0h6m-6 0h-1.5m1.5 0v5.438c0 .354.161.697.473.865a3.751 3.751 0 0 0 5.452-2.553c.083-.409-.263-.75-.68-.75h-.745M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                               </svg>


                                               <p class="text-sm whitespace-nowrap">
                                                   {{ $customerItem?->invoices?->last()?->due_amount ?? '0.00' }} </p>
                                               {{-- <button wire:click="getCustomerBal({{ $customerItem->id }})"
                                                   class="cursor-pointer">
                                                   <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-1 ml-2"
                                                       fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                       stroke="currentColor">
                                                       <path stroke-linecap="round" stroke-linejoin="round"
                                                           d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                   </svg>

                                               </button> --}}
                                           </span>
                                       @endif


                                       {{-- {{ $customerItem->status ?? 'No Status' }} --}}
                                   </td>
                                   <td class="px-3 py-2 whitespace-nowrap">

                                       @if ($customerItem->status == \App\Enums\Customer\Status::ACTIVE->value)
                                           <span
                                               class="inline-flex items-center justify-center rounded-full bg-emerald-100 px-2.5 py-0.5 text-emerald-700 dark:bg-emerald-700 dark:text-emerald-100">
                                               <p class="text-sm whitespace-nowrap">Active</p>
                                           </span>
                                       @elseif($customerItem->status == \App\Enums\Customer\Status::INACTIVE->value)
                                           <span
                                               class="inline-flex items-center justify-center rounded-full bg-red-100 px-2.5 py-0.5 text-red-700 dark:bg-red-700 dark:text-red-100">


                                               <p class="text-sm whitespace-nowrap">Inactive</p>
                                           </span>
                                       @endif


                                       {{-- {{ $customerItem->status ?? 'No Status' }} --}}
                                   </td>
                                   <td class="px-3 py-2 whitespace-nowrap">
                                       {{ $customerItem?->address ?? '' }}
                                   </td>
                                   <td class="px-3 py-2 whitespace-nowrap">
                                       <div class="flex items-center justify-center gap-2">
                                           <div class="inline-flex">
                                               @can('user.view')
                                                   <button wire:click="viewCustomer({{ $customerItem->id }})"
                                                       class="rounded-l-sm border border-gray-200 px-3 py-2 font-medium text-gray-700 transition-colors hover:bg-gray-50 hover:text-gray-900 focus:z-10 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-white focus:outline-none disabled:pointer-events-auto disabled:opacity-50 cursor-pointer">
                                                       View
                                                   </button>
                                               @endcan
                                               @can('user.edit')
                                                   <button wire:click="updateCustomerModal({{ $customerItem->id }})"
                                                       class="-ml-px border border-gray-200 px-3 py-2 font-medium text-gray-700 transition-colors hover:bg-gray-50 hover:text-gray-900 focus:z-10 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-white focus:outline-none disabled:pointer-events-auto disabled:opacity-50 curson-pointer">
                                                       Edit
                                                   </button>
                                               @endcan
                                               {{-- @can('user.delete')
                                                   <button x-data
                                                       @click="
        Swal.fire({
            title: 'Are you sure?',
            text: 'This record will be permanently deleted!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Yes, delete customer!'
        }).then((result) => {
            if (result.isConfirmed) {
                $wire.deleteCustomer({{ $customerItem->id }})
            }
        })
    "
                                                       class="-ml-px rounded-r-sm border border-gray-200 px-3 py-2 font-medium text-gray-700 transition-colors hover:bg-gray-50 hover:text-gray-900 focus:z-10 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-white focus:outline-none disabled:pointer-events-auto disabled:opacity-50 cursor-pointer">
                                                       Delete
                                                   </button>
                                               @endcan --}}
                                           </div>
                                       </div>
                                   </td>
                               </tr>
                           @endforeach
                       @else
                           <tr>
                               <td colspan="4" class="px-3 py-2 text-center">
                                   No Data Found
                               </td>
                           </tr>
                       @endif
                   </tbody>
               </table>
           </div>


           {{-- =========================== Content End Here ============================ --}}
       </div>
       <div x-cloak x-data="{ modalOpen: @entangle('viewModal') }" x-show="modalOpen" x-transition
           class="fixed inset-0 z-50 grid place-content-center bg-black/50 p-4" role="dialog" aria-modal="true"
           aria-labelledby="modalTitle">
           <div class="w-full max-w-md rounded-lg bg-white p-6 shadow-lg">
               <div class="flex items-start justify-between">
                   <h2 id="modalTitle" class="text-xl font-bold text-gray-900 sm:text-2xl">Customer Details</h2>

                   <button @click="modalOpen = false" type="button"
                       class="cursor-pointer -me-4 -mt-4 rounded-full p-2 text-gray-400 transition-colors hover:bg-gray-50 hover:text-gray-600 focus:outline-none"
                       aria-label="Close">
                       <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24"
                           stroke="currentColor">
                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                               d="M6 18L18 6M6 6l12 12"></path>
                       </svg>
                   </button>
               </div>

               <div class="mt-4">
                   @if ($customer)
                       <div class="flow-root">
                           <dl class="-my-3 divide-y divide-gray-200 text-sm">


                               <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                                   <dt class="font-medium text-gray-900">Name</dt>

                                   <dd class="text-gray-700 sm:col-span-2">{{ $customer?->name ?? '' }}</dd>
                               </div>

                               <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                                   <dt class="font-medium text-gray-900">Phone</dt>

                                   <dd class="text-gray-700 sm:col-span-2">{{ $customer?->phone ?? '' }}</dd>
                               </div>

                               <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                                   <dt class="font-medium text-gray-900">Secondary Phone</dt>

                                   <dd class="text-gray-700 sm:col-span-2">{{ $customer?->second_phone ?? '' }}</dd>
                               </div>

                               {{-- <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                                   <dt class="font-medium text-gray-900">Email</dt>

                                   <dd class="text-gray-700 sm:col-span-2">{{ $customer?->email ?? '' }}</dd>
                               </div> --}}
                               {{-- <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                                   <dt class="font-medium text-gray-900">Status</dt>

                                   <dd class="text-gray-700 sm:col-span-2">
                                       <label for="status">
                                           <select wire:model.live="status" name="status" id="status"
                                               class="mt-0.5 w-full rounded border-gray-300 shadow-sm sm:text-sm">
                                               <option value="">Please select</option>

                                               <option value="active">Active</option>
                                               <option value="inactive">Inactive</option>
                                           </select>
                                       </label>
                                   </dd>
                               </div> --}}
                               <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                                   <dt class="font-medium text-gray-900">Address</dt>

                                   <dd class="text-gray-700 sm:col-span-2">
                                       {{ $customer?->address ? $customer?->address : '' }}
                                   </dd>
                               </div>
                               <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                                   <dt class="font-medium text-gray-900">Note</dt>

                                   <dd class="text-gray-700 sm:col-span-2">
                                       {{ $customer?->note ? $customer->note : '' }}
                                   </dd>
                               </div>
                               <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                                   <dt class="font-medium text-gray-900">Last Updated at</dt>

                                   <dd class="text-gray-700 sm:col-span-2">
                                       {{ $customer?->updated_at ? $customer?->updated_at?->format('Y-m-d') : '' }}
                                   </dd>
                               </div>
                               <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                                   <dt class="font-medium text-gray-900">Created at</dt>

                                   <dd class="text-gray-700 sm:col-span-2">
                                       {{ $customer?->created_at ? $customer?->created_at?->format('Y-m-d') : '' }}
                                   </dd>
                               </div>




                           </dl>
                       </div>
                   @endif
               </div>
           </div>
       </div>
       <div x-cloak x-data="{ addUserModalOpen: @entangle('registerModal') }" x-show="addUserModalOpen" x-transition
           class="fixed inset-0 z-50 grid place-content-center bg-black/50 p-4" role="dialog" aria-modal="true"
           aria-labelledby="modalTitle">
           <div
               class="w-full md:w-md rounded-lg bg-white p-6 shadow-lg overflow-auto scrollbar scrollbar-thin scrollbar-transparent scrollbar-track-gray-100 scrollbar-thumb-gray-300 scrollbar-thumb-rounded-full scrollbar-track-rounded-full">
               <div class="flex items-start justify-between">
                   <h2 id="modalTitle" class="text-xl font-bold text-gray-900 sm:text-2xl">Add Customer</h2>

                   <button wire:click="registerModal=false" type="button"
                       class="cursor-pointer -me-4 -mt-4 rounded-full p-2 text-gray-400 transition-colors hover:bg-gray-50 hover:text-gray-600 focus:outline-none"
                       aria-label="Close">
                       <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24"
                           stroke="currentColor">
                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                               d="M6 18L18 6M6 6l12 12"></path>
                       </svg>
                   </button>
               </div>

               <div class="mt-4">

                   <form class="space-y-4" wire:submit.prevent="registerCustomer">
                       <div class="grid grid-cols-1 gap-1">
                           <label class="block text-sm font-medium text-gray-900" for="name">Name</label>
                           <input wire:model="newCustomerName"
                               class="mt-1 w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:outline-none p-2"
                               id="name" type="text" placeholder="Enter Name" />
                           @error('newCustomerName')
                               <span class="text-red-500">{{ $message }}</span>
                           @enderror
                       </div>

                       <div class="grid grid-cols-1 gap-1">
                           <label class="block text-sm font-medium text-gray-900" for="phone">Phone</label>
                           <input wire:model="newCustomerPhone"
                               class="mt-1 w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:outline-none p-2"
                               id="phone" type="text" placeholder="Enter Phone Number" />
                           @error('newCustomerPhone')
                               <span class="text-red-500">{{ $message }}</span>
                           @enderror
                       </div>
                       <div class="grid grid-cols-1 gap-1">
                           <label class="block text-sm font-medium text-gray-900" for="second_phone">Secondary
                               Phone</label>
                           <input wire:model="newCustomerSecondPhone"
                               class="mt-1 w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:outline-none p-2"
                               id="second_phone" type="text" placeholder="Enter secondary Phone Number" />
                           @error('newCustomerSecondPhone')
                               <span class="text-red-500">{{ $message }}</span>
                           @enderror
                       </div>
                       {{-- <div class="grid grid-cols-1 gap-1">
                           <label class="block text-sm font-medium text-gray-900" for="email">Email</label>
                           <input wire:model="newCustomerEmail"
                               class="mt-1 w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:outline-none p-2"
                               id="email" type="email" placeholder="Enter Email" />
                       </div> --}}
                       <div>
                           <label class="block text-sm font-medium text-gray-900" for="address">Address</label>


                           <textarea wire:model="newCustomerAddress"
                               class="mt-1 w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:outline-none p-2"
                               id="address" rows="4" placeholder="Enter Address"></textarea>
                           @error('newCustomerAddress')
                               <span class="text-red-500">{{ $message }}</span>
                           @enderror
                       </div>
                       <div>
                           <label class="block text-sm font-medium text-gray-900" for="note">Note</label>

                           <textarea wire:model="newCustomerNote"
                               class="mt-1 w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:outline-none p-2"
                               id="note" rows="4" placeholder="Enter Note"></textarea>
                           @error('newCustomerNote')
                               <span class="text-red-500">{{ $message }}</span>
                           @enderror
                       </div>

                       <button type="submit"
                           class="block w-full rounded-lg border border-indigo-600 bg-white px-12 py-3 text-sm font-medium text-indigo-600 transition-colors hover:bg-indigo-500 hover:text-white cursor-pointer">
                           Submit
                       </button>
                   </form>

               </div>
           </div>
       </div>
       <div x-cloak x-data="{ editModalOpen: @entangle('editModal') }" x-show="editModalOpen" x-transition
           class="fixed inset-0 z-50 grid place-content-center bg-black/50 p-4" role="dialog" aria-modal="true"
           aria-labelledby="modalTitle">
           <div
               class="w-full md:w-md rounded-lg bg-white p-6 shadow-lg overflow-auto scrollbar scrollbar-thin scrollbar-transparent scrollbar-track-gray-100 scrollbar-thumb-gray-300 scrollbar-thumb-rounded-full scrollbar-track-rounded-full">
               <div class="flex items-start justify-between">
                   <h2 id="modalTitle" class="text-xl font-bold text-gray-900 sm:text-2xl">Add Customer</h2>

                   <button wire:click="editModal=false" type="button"
                       class="cursor-pointer -me-4 -mt-4 rounded-full p-2 text-gray-400 transition-colors hover:bg-gray-50 hover:text-gray-600 focus:outline-none"
                       aria-label="Close">
                       <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24"
                           stroke="currentColor">
                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                               d="M6 18L18 6M6 6l12 12"></path>
                       </svg>
                   </button>
               </div>

               <div class="mt-4">

                   <form class="space-y-4" wire:submit.prevent="updateCustomer">
                       <input type="hidden" name="id" wire:model="editCustomerId">
                       <div class="grid grid-cols-1 gap-1">
                           <label class="block text-sm font-medium text-gray-900" for="name">Name</label>
                           <input wire:model="editCustomerName"
                               class="mt-1 w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:outline-none p-2"
                               id="name" type="text" placeholder="Enter Name" />
                       </div>

                       <div class="grid grid-cols-1 gap-1">
                           <label class="block text-sm font-medium text-gray-900" for="phone">Phone</label>
                           <input wire:model="editCustomerPhone"
                               class="mt-1 w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:outline-none p-2"
                               id="phone" type="text" placeholder="Enter Phone Number" />
                       </div>
                       <div class="grid grid-cols-1 gap-1">
                           <label class="block text-sm font-medium text-gray-900" for="second_phone">Secondary
                               Phone</label>
                           <input wire:model="editCustomerSecondPhone"
                               class="mt-1 w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:outline-none p-2"
                               id="second_phone" type="text" placeholder="Enter secondary Phone Number" />
                       </div>
                       {{-- <div class="grid grid-cols-1 gap-1">
                           <label class="block text-sm font-medium text-gray-900" for="email">Email</label>
                           <input wire:model="editCustomerEmail"
                               class="mt-1 w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:outline-none p-2"
                               id="email" type="email" placeholder="Enter Email" />
                       </div> --}}
                       <div class="grid grid-cols-1 gap-1">
                           <label class="block text-sm font-medium text-gray-900" for="customer_status">Status</label>
                           <select wire:model="editCustomerStatus" name="status" id="customer_status"
                               class="mt-1 w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:outline-none p-2">
                               <option value="">Please select</option>

                               <option value="active">Active</option>
                               <option value="inactive">Inactive</option>
                           </select>
                       </div>
                       {{-- <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                           <dt class="font-medium text-gray-900">Status</dt>

                           <dd class="text-gray-700 sm:col-span-2">
                               <label for="status">
                                   <select wire:model.live="status" name="status" id="status"
                                       class="mt-0.5 w-full rounded border-gray-300 shadow-sm sm:text-sm">
                                       <option value="">Please select</option>

                                       <option value="active">Active</option>
                                       <option value="inactive">Inactive</option>
                                   </select>
                               </label>
                           </dd>
                       </div> --}}
                       <div>
                           <label class="block text-sm font-medium text-gray-900" for="address">Address</label>

                           <textarea wire:model="editCustomerAddress"
                               class="mt-1 w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:outline-none p-2"
                               id="address" rows="4" placeholder="Enter Address"></textarea>
                       </div>
                       <div>
                           <label class="block text-sm font-medium text-gray-900" for="note">Note</label>

                           <textarea wire:model="editCustomerNote"
                               class="mt-1 w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:outline-none p-2"
                               id="note" rows="4" placeholder="Enter Note"></textarea>
                       </div>

                       <button type="submit"
                           class="block w-full rounded-lg border border-indigo-600 bg-white px-12 py-3 text-sm font-medium text-indigo-600 transition-colors hover:bg-indigo-500 hover:text-white cursor-pointer">
                           Submit
                       </button>
                   </form>

               </div>
           </div>
       </div>
       <div x-cloak x-data="{ balanceModalOpen: @entangle('updateBalanceModal') }" x-show="balanceModalOpen" x-transition
           class="fixed inset-0 z-50 grid place-content-center bg-black/50 p-4" role="dialog" aria-modal="true"
           aria-labelledby="modalTitle">
           <div
               class="w-full md:w-md rounded-lg bg-white p-6 shadow-lg overflow-auto scrollbar scrollbar-thin scrollbar-transparent scrollbar-track-gray-100 scrollbar-thumb-gray-300 scrollbar-thumb-rounded-full scrollbar-track-rounded-full">
               <div class="flex items-start justify-between">
                   <h2 id="modalTitle" class="text-xl font-bold text-gray-900 sm:text-2xl">Update
                       {{ $editCustomerName }} Balance</h2>

                   <button wire:click="updateBalanceModal=false" type="button"
                       class="cursor-pointer -me-4 -mt-4 rounded-full p-2 text-gray-400 transition-colors hover:bg-gray-50 hover:text-gray-600 focus:outline-none"
                       aria-label="Close">
                       <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24"
                           stroke="currentColor">
                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                               d="M6 18L18 6M6 6l12 12"></path>
                       </svg>
                   </button>
               </div>

               <div class="mt-4">

                   <form class="space-y-4" wire:submit.prevent="updateBalance">
                       <input type="hidden" name="id" wire:model="editCustomerId">
                       <label for="">Your Current Balance is: <strong>{{ $currentBalance }}</strong></label>
                       <div class="grid grid-cols-2 gap-1">

                           <div class="grid grid-cols-1 gap-1">

                               <input wire:model="amount"
                                   class="mt-1 w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:outline-none p-2"
                                   id="name" type="number" placeholder="Enter amount 0.00" step="0.01"
                                   pattern="[0-9]+(\.[0-9]+)?" />
                           </div>
                           <div class="grid grid-cols-2 gap-2">

                               <div>
                                   <label for="DeliveryStandard"
                                       class="flex items-center justify-between gap-4 rounded border border-gray-300 bg-white p-3 text-sm font-medium shadow-sm transition-colors hover:bg-gray-50 has-checked:border-blue-600 has-checked:ring-1 has-checked:ring-blue-600">
                                       <div>
                                           <p class="text-gray-700">Credit</p>
                                       </div>

                                       <input type="radio" wire:model="balupdateAction" name="balupdateAction"
                                           value="credit" id="DeliveryStandard" class="size-5 border-gray-300"
                                           checked="">
                                   </label>
                               </div>

                               <div>
                                   <label for="DeliveryPriority"
                                       class="flex items-center justify-between gap-4 rounded border border-gray-300 bg-white p-3 text-sm font-medium shadow-sm transition-colors hover:bg-gray-50 has-checked:border-blue-600 has-checked:ring-1 has-checked:ring-blue-600">
                                       <div>
                                           <p class="text-gray-700">Debit</p>
                                       </div>

                                       <input type="radio" wire:model="balupdateAction" name="debit"
                                           value="debit" id="DeliveryPriority" class="size-5 border-gray-300">
                                   </label>
                               </div>

                           </div>
                       </div>


                       <div>
                           <label class="block text-sm font-medium text-gray-900" for="note">Note</label>

                           <textarea wire:model="balupdateNote"
                               class="mt-1 w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:outline-none p-2"
                               id="note" rows="4" placeholder="Enter Note"></textarea>
                       </div>





                       <button type="submit"
                           class="block w-full rounded-lg border border-indigo-600 bg-white px-12 py-3 text-sm font-medium text-indigo-600 transition-colors hover:bg-indigo-500 hover:text-white cursor-pointer">
                           Submit
                       </button>
                   </form>

               </div>
           </div>
       </div>
       <div x-cloak x-data="{ DeletUserModalOpen: @entangle('DeletUserModal') }" x-show="DeletUserModalOpen" x-transition
           class="fixed inset-0 z-50 grid place-content-center bg-black/50 p-4" role="dialog" aria-modal="true"
           aria-labelledby="modalTitle">
           <div
               class="w-full md:w-md rounded-lg border border-red-500 bg-red-50 p-6 shadow-lg overflow-auto scrollbar scrollbar-thin scrollbar-transparent scrollbar-track-gray-100 scrollbar-thumb-gray-300 scrollbar-thumb-rounded-full scrollbar-track-rounded-full">
               <div class="flex items-start justify-between">
                   <h2 id="modalTitle" class="text-xl font-bold text-gray-900 sm:text-2xl">Delete Customer
                   </h2>

                   <button wire:click="DeletUserModal=false" type="button"
                       class="cursor-pointer -me-4 -mt-4 rounded-full p-2 text-gray-400 transition-colors hover:bg-gray-50 hover:text-gray-600 focus:outline-none"
                       aria-label="Close">
                       <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24"
                           stroke="currentColor">
                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                               d="M6 18L18 6M6 6l12 12"></path>
                       </svg>
                   </button>
               </div>

               <div class="mt-4">

                   @if ($customer)
                       <div class="flex gap-2 my-2 rounded-lg border border-gray-200 p-2">
                           <div>
                               <img class="w-12 h-12 rounded-full border border-gray-200"
                                   src="{{ asset('storage/products/5945e0d0-6125-48d6-bbe4-62c2327b29f7.jpg') }}"
                                   alt="">
                           </div>
                           <div class="flex-1">
                               <p class="font-semibold">{{ $customer->name }}</p>
                               <p class="text-sm text-gray-500">{{ $customer->phone }}</p>
                           </div>
                           <div class="flex items-center gap-1">
                               @if ($customer->status == \App\Enums\Customer\Status::ACTIVE->value)
                                   <span
                                       class="inline-flex items-center justify-center rounded-full bg-emerald-100 px-2.5 py-0.5 text-emerald-700 dark:bg-emerald-700 dark:text-emerald-100">
                                       <p class="text-sm whitespace-nowrap">Active</p>
                                   </span>
                               @elseif($customer->status == \App\Enums\Customer\Status::INACTIVE->value)
                                   <span
                                       class="inline-flex items-center justify-center rounded-full bg-red-100 px-2.5 py-0.5 text-red-700 dark:bg-red-700 dark:text-red-100">


                                       <p class="text-sm whitespace-nowrap">Inactive</p>
                                   </span>
                               @endif

                               @if ($customer && $customer?->invoices?->last()?->due_amount <= 0)
                                   <span
                                       class="inline-flex items-center justify-center rounded-full bg-emerald-100 px-2.5 py-0.5 text-emerald-700 dark:bg-emerald-700 dark:text-emerald-100">

                                       <svg xmlns="http://www.w3.org/2000/svg" class="size-6 -ms-1 me-1.5"
                                           fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                           stroke="currentColor" class="size-6">
                                           <path stroke-linecap="round" stroke-linejoin="round"
                                               d="m8.25 7.5.415-.207a.75.75 0 0 1 1.085.67V10.5m0 0h6m-6 0h-1.5m1.5 0v5.438c0 .354.161.697.473.865a3.751 3.751 0 0 0 5.452-2.553c.083-.409-.263-.75-.68-.75h-.745M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                       </svg>

                                       <p class="text-sm whitespace-nowrap">
                                           {{ $customer?->invoices?->last()?->due_amount ?? '0.00' }}
                                       </p>

                                   </span>
                               @elseif($customer && $customer?->invoices?->last()?->due_amount > 0)
                                   <span
                                       class="inline-flex items-center justify-center rounded-full bg-red-100 px-2.5 py-0.5 text-red-700 dark:bg-red-700 dark:text-red-100">
                                       <svg xmlns="http://www.w3.org/2000/svg" class="size-4 ml-1 mr-1.5"
                                           fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                           stroke="currentColor">
                                           <path stroke-linecap="round" stroke-linejoin="round"
                                               d="m8.25 7.5.415-.207a.75.75 0 0 1 1.085.67V10.5m0 0h6m-6 0h-1.5m1.5 0v5.438c0 .354.161.697.473.865a3.751 3.751 0 0 0 5.452-2.553c.083-.409-.263-.75-.68-.75h-.745M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                       </svg>


                                       <p class="text-sm whitespace-nowrap">
                                           {{ $customer?->invoices?->last()?->due_amount ?? '0.00' }}

                                       </p>

                                   </span>
                               @endif


                           </div>
                       </div>
                   @endif
                   <div role="alert" class="rounded-md  p-4 shadow-sm mb-2">
                       <div class="flex items-center justify-center gap-4">
                           <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                               stroke-width="1.5" stroke="currentColor" class="-mt-0.5 size-6 text-red-700">
                               <path stroke-linecap="round" stroke-linejoin="round"
                                   d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z">
                               </path>
                           </svg>

                           <div class="flex-1">
                               <strong class="block leading-tight font-medium text-red-800"> Delete Alert </strong>

                               <p class="mt-0.5 text-sm text-red-700">
                                   Are you sure you want to delete this customer?
                               </p>
                           </div>
                       </div>
                   </div>
                   <div class="flex justify-around items-center gap-2">
                       @if ($customer)
                           <button wire:click="deleteCustomer({{ $customer->id }})"
                               class="border border-gray-400 p-2 cursor-pointer rounded-lg bg-red-200 w-full font-bold hover:shadow-lg">Yes,
                               Delete</button>
                       @endif
                       <button wire:click="DeletUserModal=false"
                           class="border border-gray-400 p-2 rounded-lg w-full cursor-pointer hover:shadow-lg">No,
                           Cancell</button>
                   </div>
               </div>
           </div>
       </div>
   </div>


   {{-- =========================== Page Layout End Here ============================ --}}
