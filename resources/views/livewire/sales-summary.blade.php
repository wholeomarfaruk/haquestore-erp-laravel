   {{-- ======================== Page Layout Start From Here ======================== --}}
   <div x-data x-init="$store.pageName = { name: 'Sales Summary', slug: 'salessummary' }">
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

           <div class="space-y-2 pt-2">
               {{-- filter --}}
               <div
                   class="filter-bar flex items-center justify-start gap-3  mx-2 px-2 py-2 border border-gray-200 rounded-lg">
                   <span class="text-gray-400 flex gap-2">
                       <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                           stroke="currentColor" class="size-6">
                           <path stroke-linecap="round" stroke-linejoin="round"
                               d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75" />
                       </svg>

                       Filter</span>
                   <div class="daterange flex items-center gap-1 px-2 py-1 rounded-lg border border-gray-100 ">
                       <div x-data="salesDateFilter()" x-init="init()" class="flex flex-wrap items-center gap-3">
                           <!-- Preset Select -->
                           <select x-model="preset" @change="applyPreset()"
                               class="rounded-lg border border-gray-300 px-3 py-2 text-sm focus:ring-1 focus:ring-blue-500 ">
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
                               class="w-64 rounded-lg border border-gray-300 px-3 py-2 text-sm focus:ring-1 focus:ring-blue-500 disabled:bg-gray-100"
                               placeholder="Select date range" :disabled="preset !== 'custom'" />
                       </div>


                   </div>
                   <div class="customer">
                       {{-- customer info --}}
                       @if ($customer)
                           <div wire:click="selectCustomerModal=true"
                               class="flex gap-2 my-2 rounded-lg border border-gray-200 p-2 cursor-pointer  disabled:bg-gray-300 disabled:text-gray-400 disabled:cursor-not-allowed">
                               <div>
                                   <img class="w-12 h-12 rounded-full border border-gray-200"
                                       src="{{ $customer->profile_picture }}" alt="">
                               </div>
                               <div class="flex-1">
                                   <p class="font-semibold">{{ $customer->name }}</p>
                                   <p class="text-sm text-gray-500">{{ $customer->phone }}</p>
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
               {{-- stats --}}
               <div class="flex gap-2 my-2 mx-2">
                   <div class="stats flex-1 rounded-lg border border-gray-200 p-2">
                       <div class="flex items-center gap-2">
                           <div class="icon">
                               <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                   stroke-width="1.5" stroke="currentColor" class="size-6">
                                   <path stroke-linecap="round" stroke-linejoin="round"
                                       d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                               </svg>
                           </div>
                           <div class="flex-1">
                               <p class="font-semibold">Total Sales</p>
                               <p class="text-sm text-gray-500">৳ {{ number_format($totalSales, 2) }}</p>
                           </div>
                       </div>
                   </div>
                   <div class="stats flex-1 rounded-lg border border-gray-200 p-2">
                       <div class="flex items-center gap-2">
                           <div class="icon">
                               <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                   stroke-width="1.5" stroke="currentColor" class="size-6">
                                   <path stroke-linecap="round" stroke-linejoin="round"
                                       d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                               </svg>
                           </div>
                           <div class="flex-1">
                               <p class="font-semibold">Total Discount</p>
                               <p class="text-sm text-gray-500">৳ {{ number_format($totalDiscount, 2) }}</p>
                           </div>
                       </div>
                   </div>
                   <div class="stats flex-1 rounded-lg border border-gray-200 p-2">
                       <div class="flex items-center gap-2">
                           <div class="icon">
                               <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                   stroke-width="1.5" stroke="currentColor" class="size-6">
                                   <path stroke-linecap="round" stroke-linejoin="round"
                                       d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                               </svg>
                           </div>
                           <div class="flex-1">
                               <p class="font-semibold">Total Due</p>
                               <p class="text-sm text-gray-500">৳ {{ number_format($totalDue, 2) }}</p>
                           </div>
                       </div>
                   </div>

               </div>
               <div class="grid grid-cols-1 lg:grid-cols-1 mx-2 gap-2 py-2">


                   <div class="mt-6 rounded-xl border bg-white border-gray-200 p-4 h-[250px]">
                       <h3 class="mb-3 text-sm font-semibold text-gray-700">
                           Sales Trend
                       </h3>

                       <canvas id="chart_canvas" x-ref="canvas" width="500" height="250"></canvas>
                   </div>

               </div>

           </div>

           {{-- =========================== Content End Here ============================ --}}

           <div x-cloak x-data="{ selectCustomerModalOpen: @entangle('selectCustomerModal') }" x-show="selectCustomerModalOpen" x-transition
               class="fixed inset-0 z-50 grid place-content-center bg-black/50 p-4" role="dialog" aria-modal="true"
               aria-labelledby="modalTitle">
               <div
                   class="w-full md:w-md rounded-lg bg-white p-6 shadow-lg overflow-auto scrollbar scrollbar-thin scrollbar-transparent scrollbar-track-gray-100 scrollbar-thumb-gray-300 scrollbar-thumb-rounded-full scrollbar-track-rounded-full">
                   <div class="flex items-start justify-between">
                       <h2 id="modalTitle" class="text-xl font-bold text-gray-900 sm:text-2xl">Add Customer</h2>

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
                           <button wire:click="registerModal=true" type="button"
                               class="flex items-center gap-2  pb-1 text-gray-700 transition-colors hover:border-gray-400 hover:text-gray-900 cursor-pointer rounded border border-gray-300 px-4 py-2">
                               <span class="text-sm font-medium"> Add Customer</span>
                           </button>
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

                                                       <svg xmlns="http://www.w3.org/2000/svg"
                                                           class="size-6 -ms-1 me-1.5" fill="none"
                                                           viewBox="0 0 24 24" stroke-width="1.5"
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
                                                       <svg xmlns="http://www.w3.org/2000/svg"
                                                           class="size-4 ml-1 mr-1.5" fill="none"
                                                           viewBox="0 0 24 24" stroke-width="1.5"
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
           document.addEventListener('DOMContentLoaded', () => {

               const ctx = document.getElementById('chart_canvas').getContext('2d');

               let salesChart = new Chart(ctx, {
                   type: 'bar',
                   data: {
                       labels: @json($chartData['date']), // ✅ only first time
                       datasets: [{
                           label: 'Sales',
                           data: @json($chartData['amount']), // ✅ only first time
                           borderWidth: 2
                       }]
                   },
                   options: {
                       responsive: false,
                         maintainAspectRatio: true, // 🔥 THIS FIXES IT
                   }
               });

               document.addEventListener('livewire:init', () => {
                   Livewire.on('chartRefreshed', (payload) => {

                       // 🔁 REPLACE DATA
                       salesChart.data.labels = payload[0].labels;
                       salesChart.data.datasets[0].data = payload[0].data;

                       salesChart.update();
                       console.log(payload);

                       Swal.fire({
                           toast: true,
                           position: 'top-end',
                           icon: payload[0].type,
                           title: payload[0].message,
                           showConfirmButton: false,
                           timer: 3000,
                           timerProgressBar: true
                       })
                   });
               });
           });
       </script>
       {{-- <script>
           document.addEventListener('DOMContentLoaded', () => {

               const ctx = document.getElementById('pie_chart').getContext('2d');

               let pieChart = new Chart(ctx, {
                   type: 'pie',
                   data: {
                       labels: ['Sale', 'Discount', 'Due'],
                       datasets: [{
                           data: [
                               {{ $totalSales }},
                               {{ $totalDiscount }},
                               {{ $totalDue }},
                           ],
                           borderWidth: 1
                       }]
                   },
                   options: {
                       responsive: true,

                       plugins: {
                           legend: {
                               position: 'bottom'
                           }
                       }
                   }
               });

               document.addEventListener('livewire:init', () => {
                   Livewire.on('pieChartRefreshed', (data) => {
                       console.log(data);
                       pieChart.data.datasets[0].data = [
                           data[0].sale,
                           data[0].discount,
                           data[0].due
                       ];

                       pieChart.update();
                   });
               });
           });
       </script> --}}


   </div>


   {{-- =========================== Page Layout End Here ============================ --}}
