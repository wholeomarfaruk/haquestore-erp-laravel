   {{-- ======================== Page Layout Start From Here ======================== --}}
   <div x-data x-init="$store.pageName = { name: 'Dashboard', slug: 'dashboard' }">
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
                           {{-- <svg class="stroke-current" width="17" height="16" xmlns="http://www.w3.org/2000/svg"
                               fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                               class="size-6">
                               <path stroke-linecap="round" stroke-linejoin="round"
                                   d="m5.25 4.5 7.5 7.5-7.5 7.5m6-15 7.5 7.5-7.5 7.5" />
                           </svg> --}}

                       </a>
                   </li>
                   {{-- <li class="text-sm text-gray-800 dark:text-white/90" x-text="$store.pageName?.name ?? ''"></li> --}}
               </ol>
           </nav>
       </div>
       {{-- ======================== Page Header End Here ======================== --}}

       <div class="flex-1 w-full bg-white rounded-lg min-h-[80vh] pt-2">
           {{-- ======================== Content Start From Here ======================== --}}
           <div class="space-y-6 my-4 mx-2">
               <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                   <div class="rounded-lg border  border-gray-300 shadow-sm hover:shadow-lg transition-shadow">
                       <div class="p-6">
                           <div class="flex items-center justify-between">
                               <div class="">
                                   <p class=" text-sm font-medium text-gray-600">Total Sales</p>
                                   <p class="text-2xl font-bold text-gray-900">{{ number_format($totalSales, 2) }}</p>
                                   {{-- <div class="flex items-center mt-1"><svg xmlns="http://www.w3.org/2000/svg"
                                           width="24" height="24" viewBox="0 0 24 24" fill="none"
                                           stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                           stroke-linejoin="round"
                                           class="lucide lucide-trending-up h-3 w-3 text-green-500 mr-1">
                                           <polyline points="22 7 13.5 15.5 8.5 10.5 2 17"></polyline>
                                           <polyline points="16 7 22 7 22 13"></polyline>
                                       </svg><span class="text-xs text-green-600 font-medium">+12.5%</span>
                                    </div> --}}
                               </div>
                               <div class=" p-3 rounded-full bg-blue-500"><svg xmlns="http://www.w3.org/2000/svg"
                                       width="24" height="24" viewBox="0 0 24 24" fill="none"
                                       stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                       stroke-linejoin="round" class="lucide lucide-dollar-sign h-6 w-6 text-white">
                                       <line x1="12" x2="12" y1="2" y2="22"></line>
                                       <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                   </svg></div>
                           </div>
                       </div>
                   </div>
                   <div
                       class="rounded-lg border  border-gray-300 bg-card text-card-foreground shadow-sm hover:shadow-lg transition-shadow">
                       <div class="p-6">
                           <div class="flex items-center justify-between">
                               <div>
                                   <p class="text-sm font-medium text-gray-600">Monthly Sales</p>
                                   <p class="text-2xl font-bold text-gray-900">{{ number_format($monthlySales, 2) }}</p>
                                   {{-- <div class="flex items-center mt-1"><svg xmlns="http://www.w3.org/2000/svg"
                                           width="24" height="24" viewBox="0 0 24 24" fill="none"
                                           stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                           stroke-linejoin="round"
                                           class="lucide lucide-trending-up h-3 w-3 text-green-500 mr-1">
                                           <polyline points="22 7 13.5 15.5 8.5 10.5 2 17"></polyline>
                                           <polyline points="16 7 22 7 22 13"></polyline>
                                       </svg><span class="text-xs text-green-600 font-medium">+3.2%</span>
                                    </div> --}}
                               </div>
                               <div class="p-3 rounded-full bg-green-500"><svg xmlns="http://www.w3.org/2000/svg"
                                       width="24" height="24" viewBox="0 0 24 24" fill="none"
                                       stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                       stroke-linejoin="round" class="lucide lucide-dollar-sign h-6 w-6 text-white">
                                       <line x1="12" x2="12" y1="2" y2="22"></line>
                                       <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                   </svg></div>
                           </div>
                       </div>
                   </div>
                   <div
                       class="rounded-lg border  border-gray-300 bg-card text-card-foreground shadow-sm hover:shadow-lg transition-shadow">
                       <div class="p-6">
                           <div class="flex items-center justify-between">
                               <div>
                                   <p class="text-sm font-medium text-gray-600">Today Sales</p>
                                   <p class="text-2xl font-bold text-gray-900">{{ number_format($todaySales, 2) }}</p>
                                   {{-- <div class="flex items-center mt-1"><svg xmlns="http://www.w3.org/2000/svg"
                                           width="24" height="24" viewBox="0 0 24 24" fill="none"
                                           stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                           stroke-linejoin="round"
                                           class="lucide lucide-trending-up h-3 w-3 text-green-500 mr-1">
                                           <polyline points="22 7 13.5 15.5 8.5 10.5 2 17"></polyline>
                                           <polyline points="16 7 22 7 22 13"></polyline>
                                       </svg><span class="text-xs text-green-600 font-medium">+5.8%</span>
                                    </div> --}}
                               </div>
                               <div class="p-3 rounded-full bg-purple-500"><svg xmlns="http://www.w3.org/2000/svg"
                                       width="24" height="24" viewBox="0 0 24 24" fill="none"
                                       stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                       stroke-linejoin="round" class="lucide lucide-dollar-sign h-6 w-6 text-white">
                                       <line x1="12" x2="12" y1="2" y2="22"></line>
                                       <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                   </svg></div>
                           </div>
                       </div>
                   </div>
                   <div
                       class="rounded-lg border  border-gray-300 bg-card text-card-foreground shadow-sm hover:shadow-lg transition-shadow">
                       <div class="p-6">
                           <div class="flex items-center justify-between">
                               <div>
                                   <p class="text-sm font-medium text-gray-600">Total Due</p>
                                   <p class="text-2xl font-bold text-gray-900">{{ number_format($totalDue, 2) }}</p>
                                   {{-- <div class="flex items-center mt-1"><svg xmlns="http://www.w3.org/2000/svg"
                                           width="24" height="24" viewBox="0 0 24 24" fill="none"
                                           stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                           stroke-linejoin="round"
                                           class="lucide lucide-trending-up h-3 w-3 text-green-500 mr-1">
                                           <polyline points="22 7 13.5 15.5 8.5 10.5 2 17"></polyline>
                                           <polyline points="16 7 22 7 22 13"></polyline>
                                       </svg><span class="text-xs text-green-600 font-medium">+2.1%</span>
                                    </div> --}}
                               </div>
                               <div class="p-3 rounded-full bg-orange-500">
                                   <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                       viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                       stroke-linecap="round" stroke-linejoin="round"
                                       class="lucide lucide-dollar-sign h-6 w-6 text-white">
                                       <line x1="12" x2="12" y1="2" y2="22"></line>
                                       <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                   </svg>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
               <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                   <div class="rounded-lg border  border-gray-300 shadow-sm hover:shadow-lg transition-shadow">
                       <div class="p-6">
                           <h3 class="mb-3 text-sm font-semibold text-gray-700">
                               Montly Sales
                           </h3>

                           <div wire:ignore class="relative h-[300px] w-full overflow-hidden">
                               <canvas id="chart_canvas"></canvas>
                           </div>
                       </div>
                   </div>
                   <div class="rounded-lg border  border-gray-300 shadow-sm hover:shadow-lg transition-shadow">
                       <div class="p-6">
                           <div class="space-y-1.5 mb-2 flex flex-row items-center justify-between">
                               <div>
                                   <h3 class="text-2xl font-semibold leading-none tracking-tight">Recent Invoices</h3>
                                   <p class="text-sm text-muted-foreground">Last updates from your shop</p>
                               </div><a href="{{ route('company.invoice.list') }}"
                                   class="cursor-pointer inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium border border-gray-300 hover:border-indigo-600 hover:text-indigo-600 h-9 rounded-md px-3">
                                   <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                       stroke-width="2" stroke="currentColor" class="h-4 w-4 mr-2">
                                       <path stroke-linecap="round" stroke-linejoin="round"
                                           d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244" />
                                   </svg>


                                   View All</a>
                           </div>
                           <div class="space-y-4">
                               @if ($recentInvoices->count() > 0)
                                   @foreach ($recentInvoices as $item)
                                       <div
                                           class="flex items-center justify-between p-3 rounded-lg border border-gray-200 hover:shadow-sm transition-shadow">
                                           <div>
                                               <p class="text-sm font-medium text-gray-900">
                                                   {{ $item?->customer?->name }} | #{{ $item?->invoice_id }}</p>
                                               <p class="text-xs text-gray-600">
                                                   {{ $item->updated_at->diffForHumans() }}</p>
                                           </div>
                                           <div class="text-right">
                                               <p class="text-sm font-medium text-gray-900">৳ {{ $item->grand_total }}
                                               </p>
                                               <p class="text-xs text-gray-600">{{ $item->due_amount }} Due</p>
                                           </div>
                                           @if ($item->payment_status == \App\Enums\Invoice\PaymentStatus::PAID->value)
                                               <div
                                                   class="inline-flex items-center px-2.5 py-0.5 text-xs font-semibold ">
                                                   <span
                                                       class="inline-flex items-center justify-center rounded-full bg-emerald-100 px-2.5 py-0.5 text-emerald-700">
                                                       <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                           viewBox="0 0 24 24" stroke-width="1.5"
                                                           stroke="currentColor" class="-ms-1 me-1.5 size-4">
                                                           <path stroke-linecap="round" stroke-linejoin="round"
                                                               d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                           </path>
                                                       </svg>

                                                       <p class="text-sm whitespace-nowrap capitalize">
                                                           {{ $item->payment_status }}</p>
                                                   </span>
                                               </div>
                                           @else
                                               <div
                                                   class="inline-flex items-center px-2.5 py-0.5 text-xs font-semibold ">
                                                   <span
                                                       class="inline-flex items-center justify-center rounded-full bg-red-100 px-2.5 py-0.5 text-red-700">
                                                       <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                           viewBox="0 0 24 24" stroke-width="1.5"
                                                           stroke="currentColor" class="-ms-1 me-1.5 size-4">
                                                           <path stroke-linecap="round" stroke-linejoin="round"
                                                               d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z">
                                                           </path>
                                                       </svg>

                                                       <p class="text-sm whitespace-nowrap capitalize">
                                                           {{ $item->payment_status }}</p>
                                                   </span>
                                               </div>
                                           @endif
                                       </div>
                                   @endforeach
                               @endif
                           </div>
                       </div>
                   </div>
               </div>

           </div>
           {{-- =========================== Content End Here ============================ --}}
       </div>
   </div>
   {{-- =========================== Page Layout End Here ============================ --}}
   @push('scripts')
       <script>
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
                       //    responsive: true, // ✅ MUST be true
                       //    maintainAspectRatio: false, // ✅ MUST be false
                       scales: {
                           y: {
                               beginAtZero: true
                           }
                       }
                   }
               });

               document.addEventListener('livewire:init', () => {
                   Livewire.on('chartRefreshed', (payload) => {

                       // 🔁 REPLACE DATA
                       salesChart.data.labels = payload[0].labels;
                       salesChart.data.datasets[0].data = payload[0].data;

                       salesChart.update();



                   });


               });
           });
       </script>
   @endpush
