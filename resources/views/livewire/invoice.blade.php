   {{-- ======================== Page Layout Start From Here ======================== --}}
   <div x-data x-init="$store.pageName = { name: 'Manage Invoices', slug: 'invoices' }">
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
                       <details class="group relative">
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
                       </details>
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
                           <th class="px-3 py-2 whitespace-nowrap flex justify-start gap-3 items-center"> <input
                                   type="checkbox" class="my-0.5 size-5 rounded border-gray-300 shadow-sm"> Invoice</th>

                           <th class="px-3 py-2 whitespace-nowrap">Customer</th>

                           <th class="px-3 py-2 whitespace-nowrap">Status</th>
                           <th class="px-3 py-2 whitespace-nowrap">Bill</th>
                           <th class="px-3 py-2 whitespace-nowrap">Due</th>
                           <th class="px-3 py-2 whitespace-nowrap text-center">Action</th>
                       </tr>
                   </thead>

                   <tbody class="divide-y divide-gray-200">
                       <tr class="*:text-gray-900 *:first:font-medium">
                           <td class="px-3 py-2 whitespace-nowrap flex justify-start gap-2 items-center">
                               <div>
                                   <input type="checkbox" class="my-0.5 size-5 rounded border-gray-300 shadow-sm"
                                       id="Option1">
                               </div>
                               <div class=" sm:shrink-0">
                                   <span class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-200">
                                       <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none"
                                           viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                           <path stroke-linecap="round" stroke-linejoin="round"
                                               d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                       </svg>

                                   </span>
                               </div>
                               <div>
                                   <p class="font-bold mb-0 text-sm/2">INV-01</p>
                                   <span class="text-xs text-gray-400">17-12-2025</span>
                               </div>
                           </td>

                           <td class="px-3 py-2 whitespace-nowrap ">
                               <div class="flex justify-start gap-2 items-center">
                                   <div class="sm:shrink-0">
                                       <img alt=""
                                           src="https://images.unsplash.com/photo-1633332755192-727a05c4013d?auto=format&amp;fit=crop&amp;q=80&amp;w=1160"
                                           class="size-12 rounded-full object-cover sm:size-[52px]">
                                   </div>
                                   <div>
                                       <p class="font-bold mb-0 text-sm/2">Md. Omar Faruk</p>
                                       <span class="text-xs text-gray-400">01684285963</span>
                                   </div>
                               </div>

                           </td>


                           <td class="px-3 py-2 whitespace-nowrap">

                               <span
                                   class="inline-flex items-center justify-center rounded-full bg-emerald-100 px-2.5 py-0.5 text-emerald-700 dark:bg-emerald-700 dark:text-emerald-100">
                                   <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-1" fill="none"
                                       viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                       <path stroke-linecap="round" stroke-linejoin="round"
                                           d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                   </svg>
                                   <p class="text-sm whitespace-nowrap">Draft</p>
                               </span>
                               <span
                                   class="inline-flex items-center justify-center rounded-full bg-red-100 px-2.5 py-0.5 text-red-700 dark:bg-red-700 dark:text-red-100">

                                   <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                       stroke-width="1.5" stroke="currentColor" class="size-4 mr-1">
                                       <path stroke-linecap="round" stroke-linejoin="round"
                                           d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                                   </svg>

                                   <p class="text-sm whitespace-nowrap">Pending</p>
                               </span>
                               <span
                                   class="inline-flex items-center justify-center rounded-full bg-red-100 px-2.5 py-0.5 text-red-700 dark:bg-red-700 dark:text-red-100">
                                   <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                       stroke-width="1.5" stroke="currentColor" class="size-4 mr-1">
                                       <path stroke-linecap="round" stroke-linejoin="round"
                                           d="m8.25 7.5.415-.207a.75.75 0 0 1 1.085.67V10.5m0 0h6m-6 0h-1.5m1.5 0v5.438c0 .354.161.697.473.865a3.751 3.751 0 0 0 5.452-2.553c.083-.409-.263-.75-.68-.75h-.745M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                   </svg>



                                   <p class="text-sm whitespace-nowrap">unpaid</p>
                               </span>


                               {{-- {{ $invoiceItem->status ?? 'No Status' }} --}}
                           </td>
                           <td class="px-3 py-2 whitespace-nowrap">
                               1000.00
                           </td>
                           <td class="px-3 py-2 whitespace-nowrap">
                               <span
                                   class="inline-flex items-center justify-center rounded-full bg-red-100 px-2.5 py-0.5 text-red-700 dark:bg-red-700 dark:text-red-100">


                                   <p class="text-sm whitespace-nowrap">1000.00</p>
                               </span>

                           </td>
                           <td class="px-3 py-2 whitespace-nowrap">
                               <div class="flex items-center justify-center gap-2">
                                   <div class="inline-flex">

                                       <div class="relative inline-flex" x-data="{ MenuOpen: false }">
                                           <span
                                               class="inline-flex divide-x divide-gray-300 overflow-hidden rounded border border-gray-300 bg-white shadow-sm">


                                               <button type="button" x-on:click="MenuOpen = !MenuOpen"
                                                   class="px-2 py-1 cursor-pointer text-sm font-medium text-gray-700 transition-colors hover:bg-gray-50 hover:text-gray-900 focus:relative"
                                                   aria-label="Menu">
                                                   <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                       viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                       class="size-6">
                                                       <path stroke-linecap="round" stroke-linejoin="round"
                                                           d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z" />
                                                   </svg>
                                               </button>
                                           </span>

                                           <div role="menu" x-show="MenuOpen"
                                               class="absolute end-0 top-12 z-auto w-56 overflow-hidden rounded border border-gray-300 bg-white shadow-sm"
                                               {{-- :class="{'block': MenuOpen, 'hidden': !MenuOpen}" --}}>
                                               @can('invoice.view')
                                                   <button type="button"
                                                       class="block px-3 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-50 hover:text-gray-900"
                                                       role="menuitem">
                                                       View
                                                   </button>
                                               @endcan
                                               @can('invoice.edit')
                                                   <button
                                                       class="block px-3 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-50 hover:text-gray-900"
                                                       role="menuitem">
                                                       Edit
                                                   </button>
                                               @endcan

                                               <a href="#"
                                                   class="block px-3 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-50 hover:text-gray-900"
                                                   role="menuitem">
                                                   Print
                                               </a>
                                               @can('invoice.delete')
                                                   <button type="button"
                                                       class="block w-full px-3 py-2 text-sm font-medium text-red-700 transition-colors hover:bg-red-50 ltr:text-left rtl:text-right">
                                                       Delete
                                                   </button>
                                               @endcan
                                           </div>
                                       </div>
                                       {{-- @can('user.view')
                                           <button wire:click="viewCustomer()"
                                               class="rounded-l-sm border border-gray-200 px-3 py-2 font-medium text-gray-700 transition-colors hover:bg-gray-50 hover:text-gray-900 focus:z-10 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-white focus:outline-none disabled:pointer-events-auto disabled:opacity-50 cursor-pointer">
                                               View
                                           </button>
                                       @endcan
                                       @can('user.edit')
                                           <button wire:click="updateCustomerModal()"
                                               class="-ml-px border border-gray-200 px-3 py-2 font-medium text-gray-700 transition-colors hover:bg-gray-50 hover:text-gray-900 focus:z-10 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-white focus:outline-none disabled:pointer-events-auto disabled:opacity-50 curson-pointer">
                                               Edit
                                           </button>
                                       @endcan
                                       @can('user.delete')
                                           <button wire:click="deleteUser()"
                                               class="-ml-px rounded-r-sm border border-gray-200 px-3 py-2 font-medium text-gray-700 transition-colors hover:bg-gray-50 hover:text-gray-900 focus:z-10 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-white focus:outline-none disabled:pointer-events-auto disabled:opacity-50 cursor-pointer">
                                               Delete
                                           </button>
                                       @endcan --}}
                                   </div>
                               </div>
                           </td>
                       </tr>

                       @if ($invoices->count() >= 1)


                           @foreach ($invoices as $invoiceItem)
                               <tr class="*:text-gray-900 *:first:font-medium">
                                   <td class="px-3 py-2 whitespace-nowrap flex justify-start gap-2 items-center">
                                       <div>
                                           <input type="checkbox"
                                               class="my-0.5 size-5 rounded border-gray-300 shadow-sm" id="Option1">
                                       </div>
                                       <div class=" sm:shrink-0">
                                           <span
                                               class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-200">
                                               <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none"
                                                   viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                   <path stroke-linecap="round" stroke-linejoin="round"
                                                       d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                               </svg>

                                           </span>
                                       </div>
                                       <div>
                                           <p class="font-bold mb-0 text-sm/2">{{ $invoiceItem->invoice_id }}</p>
                                           <span class="text-xs text-gray-400">{{ $invoiceItem->updated_at->format('d-m-Y h:i') }}</span>
                                       </div>
                                   </td>

                                   <td class="px-3 py-2 whitespace-nowrap ">
                                       <div class="flex justify-start gap-2 items-center">
                                           <div class="sm:shrink-0">
                                               <img alt=""
                                                   src="https://images.unsplash.com/photo-1633332755192-727a05c4013d?auto=format&amp;fit=crop&amp;q=80&amp;w=1160"
                                                   class="size-12 rounded-full object-cover sm:size-[52px]">
                                           </div>
                                           <div>
                                               <p class="font-bold mb-0 text-sm/2">{{ $invoiceItem?->customer?->name ?? '' }}</p>
                                               <span class="text-xs text-gray-400">{{ $invoiceItem?->customer?->phone ?? '' }}</span><br>
                                               <span class="text-xs text-gray-400">{{ $invoiceItem?->customer?->second_phone ?? '' }}</span>
                                           </div>
                                       </div>

                                   </td>


                                   <td class="px-3 py-2 whitespace-nowrap">

                                       <span
                                           class="inline-flex items-center justify-center rounded-full bg-emerald-100 px-2.5 py-0.5 text-emerald-700 dark:bg-emerald-700 dark:text-emerald-100">
                                           <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-1" fill="none"
                                               viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                               <path stroke-linecap="round" stroke-linejoin="round"
                                                   d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                           </svg>
                                           <p class="text-sm whitespace-nowrap">{{ $invoiceItem->status }}</p>
                                       </span>
                                       <span
                                           class="inline-flex items-center justify-center rounded-full bg-red-100 px-2.5 py-0.5 text-red-700 dark:bg-red-700 dark:text-red-100">

                                           <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                               stroke-width="1.5" stroke="currentColor" class="size-4 mr-1">
                                               <path stroke-linecap="round" stroke-linejoin="round"
                                                   d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                                           </svg>

                                           <p class="text-sm whitespace-nowrap">{{ $invoiceItem->delivery_status }}</p>
                                       </span>
                                       <span
                                           class="inline-flex items-center justify-center rounded-full bg-red-100 px-2.5 py-0.5 text-red-700 dark:bg-red-700 dark:text-red-100">
                                           <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                               stroke-width="1.5" stroke="currentColor" class="size-4 mr-1">
                                               <path stroke-linecap="round" stroke-linejoin="round"
                                                   d="m8.25 7.5.415-.207a.75.75 0 0 1 1.085.67V10.5m0 0h6m-6 0h-1.5m1.5 0v5.438c0 .354.161.697.473.865a3.751 3.751 0 0 0 5.452-2.553c.083-.409-.263-.75-.68-.75h-.745M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                           </svg>



                                           <p class="text-sm whitespace-nowrap">{{ $invoiceItem->payment_status }}</p>
                                       </span>


                                       {{-- {{ $invoiceItem->status ?? 'No Status' }} --}}
                                   </td>
                                   <td class="px-3 py-2 whitespace-nowrap">
                                       {{ $invoiceItem->paid_amount}}
                                   </td>
                                   <td class="px-3 py-2 whitespace-nowrap">
                                       <span
                                           class="inline-flex items-center justify-center rounded-full bg-red-100 px-2.5 py-0.5 text-red-700 dark:bg-red-700 dark:text-red-100">
                                           <p class="text-sm whitespace-nowrap">{{ $invoiceItem->due_amount }}</p>
                                       </span>

                                   </td>
                                   <td class="px-3 py-2 whitespace-nowrap">
                                       <div class="flex items-center justify-center gap-2">
                                           <div class="inline-flex">

                                               <div class="relative inline-flex" x-data="{ MenuOpen: false }">
                                                   <span
                                                       class="inline-flex divide-x divide-gray-300 overflow-hidden rounded border border-gray-300 bg-white shadow-sm">


                                                       <button type="button" x-on:click="MenuOpen = !MenuOpen"
                                                           class="px-2 py-1 cursor-pointer text-sm font-medium text-gray-700 transition-colors hover:bg-gray-50 hover:text-gray-900 focus:relative"
                                                           aria-label="Menu">
                                                           <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                               viewBox="0 0 24 24" stroke-width="1.5"
                                                               stroke="currentColor" class="size-6">
                                                               <path stroke-linecap="round" stroke-linejoin="round"
                                                                   d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z" />
                                                           </svg>
                                                       </button>
                                                   </span>

                                                   <div role="menu" x-show="MenuOpen"
                                                       class="absolute end-0 top-12 z-auto w-56 overflow-hidden rounded border border-gray-300 bg-white shadow-sm"
                                                       {{-- :class="{'block': MenuOpen, 'hidden': !MenuOpen}" --}}>
                                                       @can('invoice.view')
                                                           <button type="button"
                                                               class="block px-3 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-50 hover:text-gray-900"
                                                               role="menuitem">
                                                               View
                                                           </button>
                                                       @endcan
                                                       @can('invoice.edit')
                                                           <button
                                                               class="block px-3 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-50 hover:text-gray-900"
                                                               role="menuitem">
                                                               Edit
                                                           </button>
                                                       @endcan

                                                       <a href="#"
                                                           class="block px-3 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-50 hover:text-gray-900"
                                                           role="menuitem">
                                                           Print
                                                       </a>
                                                       @can('invoice.delete')
                                                           <button type="button"
                                                               class="block w-full px-3 py-2 text-sm font-medium text-red-700 transition-colors hover:bg-red-50 ltr:text-left rtl:text-right">
                                                               Delete
                                                           </button>
                                                       @endcan
                                                   </div>
                                               </div>
                                               {{-- @can('user.view')
                                           <button wire:click="viewCustomer()"
                                               class="rounded-l-sm border border-gray-200 px-3 py-2 font-medium text-gray-700 transition-colors hover:bg-gray-50 hover:text-gray-900 focus:z-10 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-white focus:outline-none disabled:pointer-events-auto disabled:opacity-50 cursor-pointer">
                                               View
                                           </button>
                                       @endcan
                                       @can('user.edit')
                                           <button wire:click="updateCustomerModal()"
                                               class="-ml-px border border-gray-200 px-3 py-2 font-medium text-gray-700 transition-colors hover:bg-gray-50 hover:text-gray-900 focus:z-10 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-white focus:outline-none disabled:pointer-events-auto disabled:opacity-50 curson-pointer">
                                               Edit
                                           </button>
                                       @endcan
                                       @can('user.delete')
                                           <button wire:click="deleteUser()"
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
                               <td colspan="6" class="px-3 py-2 text-center">
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
                   @if ($invoice)
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

                               <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                                   <dt class="font-medium text-gray-900">Email</dt>

                                   <dd class="text-gray-700 sm:col-span-2">{{ $customer?->email ?? '' }}</dd>
                               </div>
                               <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
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
                               </div>
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
       {{-- <div x-cloak x-data="{ addUserModalOpen: @entangle('registerModal') }" x-show="addUserModalOpen" x-transition
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

                   <form action="#" class="space-y-4" wire:submit.prevent="registerCustomer">
                       <div class="grid grid-cols-1 gap-1">
                           <label class="block text-sm font-medium text-gray-900" for="name">Name</label>
                           <input wire:model="newCustomerName"
                               class="mt-1 w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:outline-none p-2"
                               id="name" type="text" placeholder="Enter Name" />
                       </div>

                       <div class="grid grid-cols-1 gap-1">
                           <label class="block text-sm font-medium text-gray-900" for="phone">Phone</label>
                           <input wire:model="newCustomerPhone"
                               class="mt-1 w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:outline-none p-2"
                               id="phone" type="text" placeholder="Enter Phone Number" />
                       </div>
                       <div class="grid grid-cols-1 gap-1">
                           <label class="block text-sm font-medium text-gray-900" for="second_phone">Secondary
                               Phone</label>
                           <input wire:model="newCustomerSecondPhone"
                               class="mt-1 w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:outline-none p-2"
                               id="second_phone" type="text" placeholder="Enter secondary Phone Number" />
                       </div>
                       <div class="grid grid-cols-1 gap-1">
                           <label class="block text-sm font-medium text-gray-900" for="email">Email</label>
                           <input wire:model="newCustomerEmail"
                               class="mt-1 w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:outline-none p-2"
                               id="email" type="email" placeholder="Enter Email" />
                       </div>
                       <div>
                           <label class="block text-sm font-medium text-gray-900" for="address">Address</label>

                           <textarea wire:model="newCustomerAddress"
                               class="mt-1 w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:outline-none p-2"
                               id="address" rows="4" placeholder="Enter Address"></textarea>
                       </div>
                       <div>
                           <label class="block text-sm font-medium text-gray-900" for="note">Note</label>

                           <textarea wire:model="newCustomerNote"
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

                   <form action="#" class="space-y-4" wire:submit.prevent="updateCustomer">
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
                       <div class="grid grid-cols-1 gap-1">
                           <label class="block text-sm font-medium text-gray-900" for="email">Email</label>
                           <input wire:model="editCustomerEmail"
                               class="mt-1 w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:outline-none p-2"
                               id="email" type="email" placeholder="Enter Email" />
                       </div>
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

                   <form action="#" class="space-y-4" wire:submit.prevent="updateBalance">
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
       </div> --}}
   </div>


   {{-- =========================== Page Layout End Here ============================ --}}
