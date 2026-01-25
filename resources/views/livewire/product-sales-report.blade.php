   {{-- ======================== Page Layout Start From Here ======================== --}}
   <div x-data x-init="$store.pageName = { name: 'Product Sales Report', slug: 'productsalesreport' }">
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
           <div class="flex flex-col items-center justify-around gap-3 lg:flex-row px-4 py-4 ">
               <div class="w-full lg:w-[25%]">
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
               <div class="daterange flex-1 flex items-center gap-2 w-full lg:w-auto ">
                   <div x-data="salesDateFilter()" x-init="init()"
                       class="flex flex-wrap lg:flex-nowrap items-center gap-3 w-full lg:w-auto">
                       <!-- Preset Select -->
                       <select x-model="preset" @change="applyPreset()" <select x-model="preset" @change="applyPreset()"
                           class="rounded-lg border border-gray-300 px-3 py-2 text-sm focus:ring-1 focus:ring-blue-500 w-full lg:w-1/2">
                           <option value="today">Today</option>
                           <option value="last7">Last 7 Days</option>
                           <option value="last30">Last 30 Days</option>
                           <option value="month">This Month</option>
                           <option value="year">This Year</option>
                           <option value="max">Maximum</option>
                           <option value="custom">Custom Range</option>
                       </select>

                       <!-- Date Range Picker -->
                       <input wire:model.lazy="dateRange" x-ref="range" type="text" readonly
                           class=" rounded-lg border border-gray-300 px-3 py-2 text-sm focus:ring-1 focus:ring-blue-500 disabled:bg-gray-100 w-full lg:w-1/2"
                           placeholder="Select date range" :disabled="preset !== 'custom'" />
                   </div>

                   <div class="customer w-full lg:w-auto">
                       {{-- customer info --}}
                       @if ($customer)
                           <div wire:click="selectCustomerModal=true"
                               class="flex items-center gap-2 my-2 rounded-lg border border-gray-200 p-2 cursor-pointer  disabled:bg-gray-300 disabled:text-gray-400 disabled:cursor-not-allowed">
                               <div>
                                   <img class="w-12 h-12 rounded-full border border-gray-200"
                                       src="{{ $customer->profile_picture }}" alt="">
                               </div>
                               <div class="flex-1">
                                   <p class="font-semibold">{{ $customer->name }}</p>
                                   <p class="text-sm text-gray-500">{{ $customer->phone }}</p>
                               </div>
                               <div wire:click.stop="removeCustomer()"
                                   class="cursor-pointer border border-gray-200 rounded-sm p-2">
                                   <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                       stroke-width="1.5" stroke="currentColor" class="size-4 text-red-600">
                                       <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                   </svg>

                               </div>

                           </div>
                       @else
                           <div wire:click="selectCustomerModal=true"
                               class="flex items-center gap-2 my-2 rounded-lg border border-gray-200 px-2 py-1 cursor-pointer  disabled:bg-gray-300 disabled:text-gray-400 disabled:cursor-not-allowed">
                               <div>
                                   <img class="w-10 h-10 rounded-full border border-gray-200"
                                       src="{{ asset('asset/avatar.png') }}" alt="customer-avater">
                               </div>
                               <div class="flex-1">
                                   <p class="font-semibold text-sm">Select Customer</p>
                                   <p class="text-[10px] text-gray-500">+88 01xx-xxxxxx</p>
                               </div>

                           </div>
                       @endif
                       {{-- end customer info --}}
                   </div>
               </div>

               <div>
                   {{-- <div class="flex gap-4 sm:gap-6 justify-end items-end mt-2">
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
                               class="z-auto w-64 divide-y px-2 py-2 divide-gray-300 rounded border border-gray-300 bg-white shadow-sm group-open:absolute group-open:end-0 group-open:top-8 ">
                               <div class="flex items-center justify-between px-3 py-2">
                                   <span class="text-sm text-gray-700">Filter </span>

                                   <button wire:click="resetFilter" type="button"
                                       class="text-sm text-gray-700 underline transition-colors hover:text-gray-900 cursor-pointer">
                                       Reset
                                   </button>
                               </div>

                               <fieldset class="">
                                   <legend class="sr-only">Checkboxes</legend>

                                   <div class="flex flex-col items-start gap-3">
                                       <label for="Option1" class="inline-flex items-center gap-3">
                                           <input wire:model.live="filterStockAvailable" type="checkbox"
                                               class="size-5 rounded border-gray-300 shadow-sm" id="Option1">

                                           <span class="text-sm font-medium text-gray-700">Stock Available</span>
                                       </label>
                                       <label for="Option2" class="inline-flex items-center gap-3">
                                           <input wire:model.live="filterLowStock" type="checkbox"
                                               class="size-5 rounded border-gray-300 shadow-sm" id="Option2">

                                           <span class="text-sm font-medium text-gray-700">low Stock</span>
                                       </label>
                                       <label for="Option3" class="inline-flex items-center gap-3">
                                           <input wire:model.live="filterStockOut" type="checkbox"
                                               class="size-5 rounded border-gray-300 shadow-sm" id="Option3">

                                           <span class="text-sm font-medium text-gray-700">Stock Out</span>
                                       </label>



                                   </div>
                               </fieldset>
                           </div>
                       </details>

                   </div> --}}
               </div>
           </div>

           <div class="overflow-x-auto rounded border border-gray-300 shadow-sm mx-4">
               <table class="min-w-full divide-y-2 divide-gray-200">
                   <thead class="ltr:text-left rtl:text-right">
                       <tr class="*:font-medium *:text-gray-900">
                           <th class="px-3 py-2 whitespace-nowrap flex justify-start gap-3 items-center"> <input
                                   type="checkbox" class="my-0.5 size-5 rounded border-gray-300 shadow-sm"> Product
                           </th>


                           <th class="px-3 py-2 whitespace-nowrap">Total Qty</th>

                           <th class="px-3 py-2 whitespace-nowrap">Total Sale</th>
                           <th class="px-3 py-2 whitespace-nowrap">Action</th>

                       </tr>
                   </thead>

                   <tbody class="divide-y divide-gray-200">


                       @if ($products->count() >= 1)


                           @foreach ($products as $product)
                               <tr class="*:text-gray-900 *:first:font-medium">
                                   <td class="px-3 py-2 whitespace-nowrap flex justify-start gap-2 items-center">
                                       <div>
                                           <input type="checkbox"
                                               class="my-0.5 size-5 rounded border-gray-300 shadow-sm" id="Option1">
                                       </div>
                                       <div class=" sm:shrink-0">
                                           <img alt="" src="{{ $product->product_image }}"
                                               class="size-12 rounded-lg object-cover sm:size-[52px]">

                                       </div>
                                       <div>
                                           <p class="font-bold mb-0 text-sm/2">{{ $product->name }}</p>
                                           <span class="text-xs text-gray-400">#{{ $product->id }}</span><br>

                                       </div>
                                   </td>

                                   <td class="px-3 py-2 whitespace-nowrap">
                                       {{ number_format(($product->total_quantity/$product->value_per_unit),3) }} Unit ({{ $product->total_quantity }} kg)

                                   </td>

                                   <td class="px-3 py-2 whitespace-nowrap">
                                       {{ $product->total_amount }}

                                   </td>
                                   <td class="px-3 py-2 whitespace-nowrap">
                                       <a href="{{ route('company.reports.individualproductreport', ['product_id' => $product->id]) }}"
                                           class="text-indigo-600 hover:text-indigo-900 px-2 py-1 text-sm">Report</a>
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
               <div class="my-4 mx-auto p-2">
                   {{ $products->links() }}
               </div>
           </div>


           {{-- =========================== Content End Here ============================ --}}
       </div>

       <div x-cloak x-data="{ selectCustomerModalOpen: @entangle('selectCustomerModal') }" x-show="selectCustomerModalOpen" x-transition
           class="fixed inset-0 z-50 grid place-content-center bg-black/50 p-4" role="dialog" aria-modal="true"
           aria-labelledby="modalTitle">
           <div
               class="w-full md:w-md rounded-lg bg-white p-6 shadow-lg overflow-auto scrollbar scrollbar-thin scrollbar-transparent scrollbar-track-gray-100 scrollbar-thumb-gray-300 scrollbar-thumb-rounded-full scrollbar-track-rounded-full">
               <div class="flex items-start justify-between">
                   <h2 id="modalTitle" class="text-xl font-bold text-gray-900 sm:text-2xl">Select Customer</h2>

                   <button wire:click="selectCustomerModal=false" type="button"
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
                   <div class="flex justify-end my-2">
                       {{-- <button wire:click="registerModal=true" type="button"
                           class="flex items-center gap-2  pb-1 text-gray-700 transition-colors hover:border-gray-400 hover:text-gray-900 cursor-pointer rounded border border-gray-300 px-4 py-2">
                           <span class="text-sm font-medium"> Add Customer</span>
                       </button> --}}
                   </div>

                   <div class="grid grid-cols-1 gap-1">
                       <label class="block text-sm font-medium text-gray-900" for="name">Search
                           Customer</label>
                       <input wire:model.live.debounce="searchCustomer"
                           class="mt-1 w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:outline-none p-2"
                           id="name" type="text" placeholder="Enter Name" />
                   </div>

                   <div class="grid grid-cols-1 gap-1">

                       <ul>
                           @foreach ($customers as $customeritem)
                               <li>
                                   <div @if ($customeritem->status == \App\Enums\Customer\Status::ACTIVE->value) wire:click="addCustomerInvoice({{ $customeritem->id }})" @endif
                                       class="flex gap-2 my-2 rounded-lg border border-gray-200 p-2 cursor-pointer">
                                       <div>
                                           <img class="w-12 h-12 rounded-full border border-gray-200"
                                               src="{{ $customeritem->profile_picture }}" alt="">
                                       </div>
                                       <div class="flex-1">
                                           <p class="font-semibold">{{ $customeritem->name }}</p>
                                           <p class="text-sm text-gray-500">{{ $customeritem->phone }}</p>
                                       </div>
                                       <div>
                                           @if ($customeritem->status == \App\Enums\Customer\Status::ACTIVE->value)
                                               <span
                                                   class="inline-flex items-center justify-center rounded-full bg-emerald-100 px-2.5 py-0.5 text-emerald-700 dark:bg-emerald-700 dark:text-emerald-100">
                                                   <p class="text-sm whitespace-nowrap">Active</p>
                                               </span>
                                           @elseif($customeritem->status == \App\Enums\Customer\Status::INACTIVE->value)
                                               <span
                                                   class="inline-flex items-center justify-center rounded-full bg-red-100 px-2.5 py-0.5 text-red-700 dark:bg-red-700 dark:text-red-100">


                                                   <p class="text-sm whitespace-nowrap">Inactive</p>
                                               </span>
                                           @endif

                                           @if ($customeritem && $customeritem?->invoices?->last()?->due_amount <= 0)
                                               <span
                                                   class="inline-flex items-center justify-center rounded-full bg-emerald-100 px-2.5 py-0.5 text-emerald-700 dark:bg-emerald-700 dark:text-emerald-100">

                                                   <svg xmlns="http://www.w3.org/2000/svg" class="size-6 -ms-1 me-1.5"
                                                       fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                       stroke="currentColor" class="size-6">
                                                       <path stroke-linecap="round" stroke-linejoin="round"
                                                           d="m8.25 7.5.415-.207a.75.75 0 0 1 1.085.67V10.5m0 0h6m-6 0h-1.5m1.5 0v5.438c0 .354.161.697.473.865a3.751 3.751 0 0 0 5.452-2.553c.083-.409-.263-.75-.68-.75h-.745M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                   </svg>

                                                   <p class="text-sm whitespace-nowrap">
                                                       {{ $customeritem?->invoices?->last()?->due_amount ?? '0.00' }}
                                                   </p>

                                               </span>
                                           @elseif($customeritem && $customeritem?->invoices?->last()?->due_amount > 0)
                                               <span
                                                   class="inline-flex items-center justify-center rounded-full bg-red-100 px-2.5 py-0.5 text-red-700 dark:bg-red-700 dark:text-red-100">
                                                   <svg xmlns="http://www.w3.org/2000/svg" class="size-4 ml-1 mr-1.5"
                                                       fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                       stroke="currentColor">
                                                       <path stroke-linecap="round" stroke-linejoin="round"
                                                           d="m8.25 7.5.415-.207a.75.75 0 0 1 1.085.67V10.5m0 0h6m-6 0h-1.5m1.5 0v5.438c0 .354.161.697.473.865a3.751 3.751 0 0 0 5.452-2.553c.083-.409-.263-.75-.68-.75h-.745M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                   </svg>


                                                   <p class="text-sm whitespace-nowrap">
                                                       {{ $customeritem?->invoices?->last()?->due_amount ?? '0.00' }}

                                                   </p>

                                               </span>
                                           @endif

                                       </div>
                                   </div>
                               </li>
                           @endforeach


                       </ul>
                   </div>

               </div>
           </div>
       </div>

       <script>
           function salesDateFilter() {
               return {
                   preset: 'today',
                   fp: null,
                   start: null,
                   end: null,

                   init() {
                       this.fp = flatpickr(this.$refs.range, {
                           mode: 'range',
                           dateFormat: 'Y-m-d',
                           onChange: (dates) => {
                               if (dates.length === 2) {
                                   this.start = this.format(dates[0])
                                   this.end = this.format(dates[1])

                                   Livewire.dispatch('dateChanged', {
                                       start: this.start,
                                       end: this.end
                                   })
                               }
                           }
                       })

                       // Default preset
                       this.applyPreset()
                   },

                   applyPreset() {
                       let start, end = this.today()

                       switch (this.preset) {
                           case 'today':
                               start = end = this.today()
                               break

                           case 'last7':
                               start = this.daysAgo(6)
                               break

                           case 'last30':
                               start = this.daysAgo(29)
                               break

                           case 'month':
                               start = new Date(new Date().getFullYear(), new Date().getMonth(), 1)
                               break

                           case 'year':
                               start = new Date(new Date().getFullYear(), 0, 1)
                               break

                           case 'max':
                               start = '2000-01-01'
                               break

                           case 'custom':
                               return
                       }

                       this.fp.setDate([start, end], true)

                       Livewire.dispatch('dateChanged', {
                           start: this.format(start),
                           end: this.format(end)
                       })
                   },

                   today() {
                       return this.format(new Date())
                   },

                   daysAgo(days) {
                       let d = new Date()
                       d.setDate(d.getDate() - days)
                       return this.format(d)
                   },

                   format(date) {
                       if (typeof date === 'string') return date
                       return date.toISOString().split('T')[0]
                   }
               }
           }
       </script>
   </div>


   {{-- =========================== Page Layout End Here ============================ --}}
