   {{-- ======================== Page Layout Start From Here ======================== --}}
   <div x-data x-init="$store.pageName = { name: 'Sales Point', slug: 'sales' }">
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
           <div class="grid grid-cols-1 lg:grid-cols-6 gap-2">
               <div class="col-span-1 lg:col-span-4 p-2 order-2 lg:order-1">
                   {{-- start search and filter --}}
                   <div x-data="{ filter: false }"
                       class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 relative my-3 mx-2 sm:mx-4 px-2">
                       <div>
                           <button @click="filter = !filter" class="cursor-pointer px-4 py-2 rounded-lg bg-gray-100">
                               <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                   stroke-width="2" stroke="currentColor" class="size-6">
                                   <path stroke-linecap="round" stroke-linejoin="round"
                                       d="M6 13.5V3.75m0 9.75a1.5 1.5 0 0 1 0 3m0-3a1.5 1.5 0 0 0 0 3m0 3.75V16.5m12-3V3.75m0 9.75a1.5 1.5 0 0 1 0 3m0-3a1.5 1.5 0 0 0 0 3m0 3.75V16.5m-6-9V3.75m0 3.75a1.5 1.5 0 0 1 0 3m0-3a1.5 1.5 0 0 0 0 3m0 9.75V10.5" />
                               </svg>

                           </button>
                       </div>
                       <div class="flex-1">
                           <label for="Search">
                               <div class="relative">
                                   <input wire:model.live.debounce="search" type="text" id="Search"
                                       placeholder="Search Product..."
                                       class="mt-0.5 h-10 w-full  rounded border-gray-300 pr-10 pl-2 shadow-sm sm:text-sm focus-within:outline-0.5 focus-within:outline-blue-400">

                                   <span class="absolute inset-y-0 right-2 grid w-8 place-content-center ">
                                       <button type="button" aria-label="Submit"
                                           class="cursor-pointer rounded-full p-1.5 text-gray-700 transition-colors hover:bg-gray-100">
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
                       <div x-show="filter" x-cloak @click.outside="filter = false"
                           class="absolute top-full left-0 right-0 z-40 mt-2 px-4 py-2 shadow-sm w-full bg-white rounded-lg border border-gray-200">
                           <div class="space-y-4 flex items-center justify-between py-1 mb-1 border-b border-gray-200 ">
                               <div class="flex items-center gap-1">
                                   <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                       stroke-width="2" stroke="currentColor" class="size-6">
                                       <path stroke-linecap="round" stroke-linejoin="round"
                                           d="M6 13.5V3.75m0 9.75a1.5 1.5 0 0 1 0 3m0-3a1.5 1.5 0 0 0 0 3m0 3.75V16.5m12-3V3.75m0 9.75a1.5 1.5 0 0 1 0 3m0-3a1.5 1.5 0 0 0 0 3m0 3.75V16.5m-6-9V3.75m0 3.75a1.5 1.5 0 0 1 0 3m0-3a1.5 1.5 0 0 0 0 3m0 9.75V10.5" />
                                   </svg>
                                   <span>Filter</span>
                               </div>
                               <div>
                                   <button @click="filter = false"
                                       class="rounded p-1.5 text-gray-700  shadow-sm  transition-colors hover:bg-gray-100 "
                                       title="Close"><svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                           viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                           <path stroke-linecap="round" stroke-linejoin="round"
                                               d="M6 18 18 6M6 6l12 12" />
                                       </svg>
                                   </button>
                               </div>
                           </div>
                           <div class="space-y-4">
                               <details class="group relative overflow-hidden rounded border border-gray-300 shadow-sm">
                                   <summary
                                       class="flex items-center justify-between gap-2 p-3 text-gray-700 transition-colors hover:text-gray-900 [&amp;::-webkit-details-marker]:hidden">
                                       <span class="text-sm font-medium"> Availability </span>

                                       <span class="transition-transform group-open:-rotate-180">
                                           <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                               stroke-width="1.5" stroke="currentColor" class="size-4">
                                               <path stroke-linecap="round" stroke-linejoin="round"
                                                   d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path>
                                           </svg>
                                       </span>
                                   </summary>

                                   <div class="divide-y divide-gray-300 border-t border-gray-300 bg-white">
                                       <div class="flex items-center justify-between px-3 py-2">
                                           <span class="text-sm text-gray-700"> 0 Selected </span>

                                           <button type="button"
                                               class="text-sm text-gray-700 underline transition-colors hover:text-gray-900">
                                               Reset
                                           </button>
                                       </div>

                                       <fieldset class="p-3">
                                           <legend class="sr-only">Checkboxes</legend>

                                           <div class="flex flex-col items-start gap-3">
                                               <label for="Option1" class="inline-flex items-center gap-3">
                                                   <input type="checkbox"
                                                       class="size-5 rounded border-gray-300 shadow-sm"
                                                       id="Option1">

                                                   <span class="text-sm font-medium text-gray-700"> Option 1 </span>
                                               </label>

                                               <label for="Option2" class="inline-flex items-center gap-3">
                                                   <input type="checkbox"
                                                       class="size-5 rounded border-gray-300 shadow-sm"
                                                       id="Option2">

                                                   <span class="text-sm font-medium text-gray-700"> Option 2 </span>
                                               </label>

                                               <label for="Option3" class="inline-flex items-center gap-3">
                                                   <input type="checkbox"
                                                       class="size-5 rounded border-gray-300 shadow-sm"
                                                       id="Option3">

                                                   <span class="text-sm font-medium text-gray-700"> Option 3 </span>
                                               </label>
                                           </div>
                                       </fieldset>
                                   </div>
                               </details>

                               <details
                                   class="group relative overflow-hidden rounded border border-gray-300 shadow-sm">
                                   <summary
                                       class="flex items-center justify-between gap-2 p-3 text-gray-700 transition-colors hover:text-gray-900 [&amp;::-webkit-details-marker]:hidden">
                                       <span class="text-sm font-medium"> Price </span>

                                       <span class="transition-transform group-open:-rotate-180">
                                           <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                               stroke-width="1.5" stroke="currentColor" class="size-4">
                                               <path stroke-linecap="round" stroke-linejoin="round"
                                                   d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path>
                                           </svg>
                                       </span>
                                   </summary>

                                   <div class="divide-y divide-gray-300 border-t border-gray-300 bg-white">
                                       <div class="flex items-center justify-between px-3 py-2">
                                           <span class="text-sm text-gray-700"> Max price is $600 </span>

                                           <button type="button"
                                               class="text-sm text-gray-700 underline transition-colors hover:text-gray-900">
                                               Reset
                                           </button>
                                       </div>

                                       <div class="flex items-center gap-3 p-3">
                                           <label for="MinPrice">
                                               <span class="text-sm text-gray-700"> Min </span>

                                               <input type="number" id="MinPrice" value="0"
                                                   class="mt-0.5 w-full rounded border-gray-300 shadow-sm sm:text-sm">
                                           </label>

                                           <label for="MaxPrice">
                                               <span class="text-sm text-gray-700"> Max </span>

                                               <input type="number" id="MaxPrice" value="600"
                                                   class="mt-0.5 w-full rounded border-gray-300 shadow-sm sm:text-sm">
                                           </label>
                                       </div>
                                   </div>
                               </details>
                           </div>
                       </div>
                   </div>
                   {{-- end search and filter --}}
                   {{-- start product --}}
                   <div class="overflow-x-auto rounded mx-4 px-2">
                       <div class="min-w-full divide-y-2 divide-gray-200">
                           <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                               @if ($products->count() > 0)
                                   @foreach ($products as $product)
                                       <div title="{{ $product->name }}" comment="Product Card">
                                           <div
                                               class="block relative rounded-lg p-4 shadow-lg border border-gray-200 ">
                                               <img alt="" src="{{ $product->product_image }}"
                                                   class="h-30 sm:h-26 w-full object-cover {{ $product->stock_status == \App\Enums\Product\StockStatus::STOCK_OUT->value || $product->stock <= 0 ? 'sepia' : '' }}">

                                               <div class="">
                                                   <dl>
                                                       <span>
                                                           <dt class="sr-only">Qty: </dt>

                                                           <span class="text-sm text-gray-500" title="Quantity">
                                                               {{ $product->stock . ' ' . $product->unit_name }}</span>
                                                       </span>
                                                       <span class="divider size-6 text-gray-500">|</span>
                                                       @if (false && $product->discount_price > 0)
                                                           <span>
                                                               <dt class="sr-only">Price: </dt>

                                                               <del class="text-[10px] text-gray-500"
                                                                   title="Regular Price: {{ $product->price . ' Tk' }}">
                                                                   {{ $product->price }}</del>
                                                           </span>

                                                           <span>
                                                               <dt class="sr-only">Discount Price: </dt>

                                                               <span class="text-sm text-gray-500"
                                                                   title="Discount Price"
                                                                   title="Discount Price: {{ $product->discount_price . ' Tk' }}">
                                                                   {{ $product->discount_price . ' Tk' }}</span>
                                                           </span>
                                                       @else
                                                           <span>
                                                               <dt class="sr-only">Price: </dt>

                                                               <span class="text-sm text-gray-500"
                                                                   title="Regular Price: {{ $product->price . ' Tk' }}">

                                                                   {{ $product->price . ' Tk' }}</span>
                                                           </span>
                                                       @endif
                                                       <div>
                                                           <dt class="sr-only">Name:</dt>

                                                           <dd
                                                               class="font-medium {{ $product->stock_status == \App\Enums\Product\StockStatus::STOCK_OUT->value || $product->stock == 0 ? 'text-gray-400' : '' }}">
                                                               {{ $product->name }}</dd>
                                                       </div>
                                                   </dl>





                                                   <div class="mt-4 flex items-center justify-between gap-2 text-xs">
                                                       <label for="Quantity" class="sr-only"> Quantity
                                                       </label>

                                                       <div x-data="{
                                                           qty: @entangle('qtyInput.' . $product->id).live
                                                       }"
                                                           class="flex items-center rounded-lg border border-gray-200 px-2 w-[85%]">


                                                           <button type="button" @click="if(qty > 1) qty--"
                                                               {{ $product->stock_status == \App\Enums\Product\StockStatus::STOCK_OUT->value || $product->stock <= 0 ? 'disabled' : '' }}
                                                               class=" text-gray-600 flex-1 rounded-full text-center transition hover:text-white hover:bg-gray-600 cursor-pointer disabled:bg-gray-200 disabled:text-gray-50 disabled:cursor-not-allowed">
                                                               <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                   viewBox="0 0 24 24" stroke-width="1.5"
                                                                   stroke="currentColor" class="size-6">
                                                                   <path stroke-linecap="round"
                                                                       stroke-linejoin="round"
                                                                       d="M15 12H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                               </svg>

                                                           </button>

                                                           <input type="number" id="Quantity" x-model="qty"
                                                               {{ $product->stock_status == \App\Enums\Product\StockStatus::STOCK_OUT->value || $product->stock <= 0 ? 'disabled' : '' }}
                                                               value="1"
                                                               class="h-10 w-[70%] border-transparent text-center [-moz-appearance:textfield] sm:text-sm [&amp;::-webkit-inner-spin-button]:m-0 [&amp;::-webkit-inner-spin-button]:appearance-none [&amp;::-webkit-outer-spin-button]:m-0 [&amp;::-webkit-outer-spin-button]:appearance-none  disabled:text-gray-50 disabled:cursor-not-allowed  focus-visible:ring-2  focus-visible:outline-none">

                                                           <button type="button" @click="qty++"
                                                               {{ $product->stock_status == \App\Enums\Product\StockStatus::STOCK_OUT->value || $product->stock <= 0 ? 'disabled' : '' }}
                                                               class=" text-gray-600 flex-1  rounded-full text-center transition hover:text-white hover:bg-gray-600 cursor-pointer disabled:bg-gray-200 disabled:text-gray-50 disabled:cursor-not-allowed">
                                                               <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                   viewBox="0 0 24 24" stroke-width="1.5"
                                                                   stroke="currentColor" class="size-6">
                                                                   <path stroke-linecap="round"
                                                                       stroke-linejoin="round"
                                                                       d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                               </svg>

                                                           </button>
                                                       </div>



                                                       <div class="w-[15%]">

                                                           <button type="button"
                                                               wire:click="addToCart({{ $product->id }})"
                                                               {{ $product->stock_status == \App\Enums\Product\StockStatus::STOCK_OUT->value || $product->stock <= 0 ? 'disabled' : '' }}
                                                               class="h-10 w-8 text-gray-z600 rounded-lg border border-gray-200 text-center transition hover:text-white hover:bg-gray-600 cursor-pointer disabled:bg-gray-200 disabled:text-gray-50 disabled:cursor-not-allowed">
                                                               <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                   viewBox="0 0 24 24" stroke-width="1.5"
                                                                   stroke="currentColor" class="size-6 mx-auto">
                                                                   <path stroke-linecap="round"
                                                                       stroke-linejoin="round"
                                                                       d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                                               </svg>



                                                           </button>

                                                       </div>
                                                   </div>

                                                   <div
                                                       class="absolute top-5 right-5 left-5 flex items-center gap-2 justify-between">
                                                       <div>
                                                           <span
                                                               class="inline-flex items-center justify-center rounded-full bg-black opacity-50 px-2.5 py-0.5 text-white">
                                                               <p class="text-sm whitespace-nowrap">
                                                                   #{{ $product->id }}
                                                               </p>
                                                           </span>
                                                       </div>
                                                       <div>
                                                           @if ($product->stock_status == \App\Enums\Product\StockStatus::STOCK_OUT->value || $product->unit_value <= 0)
                                                               <span
                                                                   class="inline-flex items-center justify-center rounded-full bg-red-100 px-2.5 py-0.5 text-red-700 dark:bg-red-700 dark:text-red-100">

                                                                   <svg xmlns="http://www.w3.org/2000/svg"
                                                                       fill="none" viewBox="0 0 24 24"
                                                                       stroke-width="1.5" stroke="currentColor"
                                                                       class="size-4 mr-1">
                                                                       <path stroke-linecap="round"
                                                                           stroke-linejoin="round"
                                                                           d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                                                   </svg>




                                                                   <p class="text-sm whitespace-nowrap">Stock Out</p>
                                                               </span>
                                                           @elseif (false)
                                                               <span
                                                                   class="inline-flex items-center justify-center rounded-full bg-emerald-100 px-2.5 py-0.5 text-emerald-700 dark:bg-emerald-700 dark:text-emerald-100">
                                                                   <svg xmlns="http://www.w3.org/2000/svg"
                                                                       fill="none" viewBox="0 0 24 24"
                                                                       stroke-width="1.5" stroke="currentColor"
                                                                       class="-ms-1 me-1.5 size-4">
                                                                       <path stroke-linecap="round"
                                                                           stroke-linejoin="round"
                                                                           d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                                       </path>
                                                                   </svg>

                                                                   <p class="text-sm whitespace-nowrap">Added</p>
                                                               </span>
                                                           @endif
                                                       </div>

                                                   </div>
                                               </div>
                                           </div>
                                       </div>
                                   @endforeach
                               @endif
                           </div>
                       </div>
                   </div>
                   {{-- end product --}}
               </div>
               <div
                   class="col-span-1 lg:col-span-2 order-1 lg:order-2 border-l lg:border-l border-gray-300 min-h-screen p-2">
                   {{-- add to cart  --}}
                   <div>
                       <p class="font-semibold text-lg">{{ $activeInvoice['invoice_id'] ?? 'New Invoice' }}</p>
                       <!-- Slider main container -->
                       <div class="flex justify-between items-end gap-2 my-2">

                           <div class="flex justify-start ">
                               <button type="button"
                                   @if ($activeInvoice && $activeInvoice['status'] == \App\Enums\Invoice\Status::COMPLETED->value) disabled @else wire:click="selectCustomerModal=true" @endif
                                   class="flex items-center gap-2  pb-1 text-gray-700 transition-colors hover:border-gray-400 hover:text-gray-900 cursor-pointer rounded border border-gray-300 px-4 py-2 disabled:bg-gray-300 disabled:text-gray-400  disabled:cursor-not-allowed">
                                   <span class="text-sm font-medium"> Add Customer</span>
                               </button>
                           </div>
                           <button wire:click="makeInvoice" type="button"
                               class="flex items-center gap-2  pb-1 text-gray-700 transition-colors hover:border-gray-400 hover:text-gray-900 cursor-pointer rounded border border-gray-300 px-4 py-2">
                               <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                   stroke-width="1.5" stroke="currentColor" class="size-4">
                                   <path stroke-linecap="round" stroke-linejoin="round"
                                       d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                               </svg>

                               <span class="text-sm font-medium">New Invoice</span>
                           </button>
                       </div>
                       <hr>
                       {{-- customer info --}}
                       @if ($activeInvoice && $customer)
                           <div @if ($activeInvoice && $activeInvoice['status'] == \App\Enums\Invoice\Status::COMPLETED->value) disabled @else wire:click="selectCustomerModal=true" @endif
                               class="flex gap-2 my-2 rounded-lg border border-gray-200 p-2 cursor-pointer  disabled:bg-gray-300 disabled:text-gray-400 disabled:cursor-not-allowed">
                               <div>
                                   <img class="w-12 h-12 rounded-full border border-gray-200"
                                       src="{{ $customer->profile_picture }}"
                                       alt="">
                               </div>
                               <div class="flex-1">
                                   <p class="font-semibold">{{ $customer->name }}</p>
                                   <p class="text-sm text-gray-500">{{ $customer->phone }}</p>
                               </div>

                           </div>
                       @endif
                       {{-- end customer info --}}
                       {{-- start invoice items --}}
                       <ul>

                           @if ($activeInvoice && count($activeInvoice['items']) > 0)

                               @foreach ($activeInvoice['items'] as $item)
                                   <li wire:key="invoice-item-{{ $item['id'] }}">
                                       <div class="flex items-center gap-2 p-2 rounded-lg border border-gray-200 mb-3">
                                           <div class="">
                                               <img class="h-20 w-18 rounded-lg" src="{{ $item['image'] }}"
                                                   alt="">
                                           </div>
                                           <div class="flex-1">
                                               <p class="font-semibold">{{ $item['name'] }}</p>

                                               <div class="text-gray-500 flex justify-between items-center gap-2">
                                                   <div class="flex justify-start items-center gap-1">
                                                       <span class="text-gray-500 flex items-center gap-1">
                                                           <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                               viewBox="0 0 24 24" stroke-width="1.5"
                                                               stroke="currentColor" class="size-4">
                                                               <path stroke-linecap="round" stroke-linejoin="round"
                                                                   d="m8.25 7.5.415-.207a.75.75 0 0 1 1.085.67V10.5m0 0h6m-6 0h-1.5m1.5 0v5.438c0 .354.161.697.473.865a3.751 3.751 0 0 0 5.452-2.553c.083-.409-.263-.75-.68-.75h-.745M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                           </svg>


                                                           {{ $item['price'] }}
                                                       </span>
                                                       <span class="text-gray-500">x</span>

                                                       <span class="text-gray-500">{{ $item['quantity'] }} =</span>
                                                   </div>
                                                   <div>
                                                       <span title="sub total"
                                                           class="font-bold flex justify-start items-center">
                                                           <span class=" flex items-center">


                                                               Tk {{ number_format($item['total'], 2) }}
                                                           </span>
                                                       </span>
                                                   </div>
                                               </div>


                                               <div class="flex justify-between items-center gap-2">
                                                   <div>
                                                       <button class="cursor-pointer">
                                                           <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                               viewBox="0 0 24 24" stroke-width="2"
                                                               stroke="currentColor" class="size-4 text-indigo-400">
                                                               <path stroke-linecap="round" stroke-linejoin="round"
                                                                   d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                           </svg>


                                                       </button>
                                                       <button title="Remove" class="cursor-pointer"
                                                           wire:click="removeFromCart({{ $item['id'] }})">
                                                           <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                               viewBox="0 0 24 24" stroke-width="1.5"
                                                               stroke="currentColor" class="size-4 text-red-400">
                                                               <path stroke-linecap="round" stroke-linejoin="round"
                                                                   d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                           </svg>



                                                       </button>
                                                   </div>
                                                   <div>
                                                       <div class="flex-1">
                                                           {{-- Cart Quantity --}}
                                                           <div x-data="{
                                                               qty: @entangle('qtyInput.' . $item['id']).live
                                                           }"
                                                               class="flex items-center rounded-lg border border-gray-200 px-2">
                                                               <!-- Minus -->
                                                               <button type="button" @click="if(qty > 1) qty--"
                                                                   class="text-gray-600 rounded-full hover:text-white hover:bg-gray-600">
                                                                   <svg xmlns="http://www.w3.org/2000/svg"
                                                                       class="size-4" fill="none"
                                                                       viewBox="0 0 24 24" stroke="currentColor">
                                                                       <path stroke-linecap="round"
                                                                           stroke-linejoin="round" d="M15 12H9" />
                                                                   </svg>
                                                               </button>

                                                               <!-- Input -->
                                                               <input type="number" x-model="qty" min="1"
                                                                   class="h-6 w-30 border-transparent text-center sm:text-sm appearance-none focus-visible:outline-none" />

                                                               <!-- Plus -->
                                                               <button type="button" @click="qty++"
                                                                   class="text-gray-600 rounded-full hover:text-white hover:bg-gray-600">
                                                                   <svg xmlns="http://www.w3.org/2000/svg"
                                                                       class="size-4" fill="none"
                                                                       viewBox="0 0 24 24" stroke="currentColor">
                                                                       <path stroke-linecap="round"
                                                                           stroke-linejoin="round" d="M12 9v6m3-3H9" />
                                                                   </svg>
                                                               </button>
                                                           </div>

                                                       </div>
                                                   </div>
                                               </div>
                                           </div>
                                       </div>

                                   </li>
                               @endforeach
                           @else
                               <li class="text-center text-gray-600">No Item Found</li>
                           @endif
                       </ul>
                       {{-- end invoice items --}}
                       {{-- invoice summery --}}
                       @if ($activeInvoice && count($activeInvoice['items']) > 0)
                           <div class="overflow-x-auto">
                               <hr class="my-4">
                               <table class="w-full table-fixed divide-y-2 divide-gray-200">

                                   <tbody class="divide-y divide-gray-200 *:even:bg-gray-50">
                                       <tr class="*:text-gray-900 *:first:font-medium *:first:w-fit *:first:min-w-fit">

                                           <th class="px-3 py-2 text-start whitespace-nowrap ">Sub Total

                                           </th>
                                           <td class="px-3 py-2 text-end whitespace-nowrap w-full">
                                               Tk {{ number_format($activeInvoice['total'], 2) }} </td>
                                       </tr>

                                       <tr x-data="{ discountOpen: @entangle('discountOpen') }" wire:click="openDiscount('open')"
                                           class="relative *:text-gray-900 *:first:font-medium cursor-pointer hover:text-gray-900 !important hover:bg-emerald-200!">
                                           <th class="px-3 py-2 text-start whitespace-nowrap flex">Discount
                                               <span class="ml-1">
                                                   <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                       viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                       class="size-4">
                                                       <path stroke-linecap="round" stroke-linejoin="round"
                                                           d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                   </svg>
                                               </span>
                                           </th>
                                           <td class="px-3 py-2 text-end whitespace-nowrap relative w-full">
                                               {{-- Tk {{ number_format($activeInvoice['discount'], 2) }} --}}
                                               {{-- <div x-show="discountOpen" x-transition x-cloak @click.stop
                                                   class="absolute px-2 py-1 end-0 text-sm top-[10px] z-auto w-60 overflow-hidden rounded border border-gray-300 bg-white shadow-sm flex items-center flex-wrap gap-2">
                                                   <input type="number" step="0.01" min="0"
                                                       wire:model.live.debounce.500ms="discountAmount"
                                                       class="mt-1 w-[70%] rounded-lg border border-gray-300 focus:border-indigo-500 focus:outline-none p-2"
                                                       placeholder="0.00" />


                                                   <span wire:click="openDiscount('close')" class="w-[20%]">

                                                       <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                           viewBox="0 0 24 24" stroke-width="1.5"
                                                           stroke="currentColor"
                                                           class="size-5 text-emerald-600 hover:text-emerald-500 cursor-pointer">
                                                           <path stroke-linecap="round" stroke-linejoin="round"
                                                               d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                       </svg>

                                                   </span>
                                                   @error('discountAmount')
                                                       <span class="text-sm text-left text-red-600 w-full">
                                                           {{ $message }}
                                                       </span>
                                                   @enderror


                                               </div> --}}
                                               <input type="text" class="text-end focus-within:outline-0"
                                                   min="0" wire:model.live.debounce.1000ms="discountAmount"
                                                   wire:model.blur="discountAmount"
 inputmode="decimal"
    oninput="this.value = this.value
        .replace(/[^0-9.]/g, '')
        .replace(/(\..*)\./g, '$1');"
                                                   >
                                               @error('discountAmount')
                                                   <br>
                                                   <span class="text-sm text-left text-red-600 w-full">
                                                       {{ $message }}
                                                   </span>
                                               @enderror
                                           </td>
                                       </tr>


                                       <tr class="*:text-gray-900 *:first:font-medium bg-gray-300! rounded-lg">

                                           <th class="px-3 py-2 text-start whitespace-nowrap ">Grand Total

                                           </th>
                                           <td class="px-3 py-2 text-end whitespace-nowrap font-semibold w-full">
                                               Tk {{ number_format($activeInvoice['grand_total'], 2) }}</td>
                                       </tr>
                                       <tr class="*:text-gray-900 *:first:font-medium ">

                                           <th
                                               class="px-3 py-2 text-start whitespace-nowrap text-red-500! font-semibold ">
                                               Previous Due
                                               <p class="text-xs">
                                                   {{ $activeInvoice['previous_invoice_id'] ?? null }}
                                               </p>

                                           </th>
                                           <td
                                               class="px-3 py-2 text-end whitespace-nowrap text-red-500! font-semibold w-full">
                                               Tk {{ number_format($activeInvoice['previous_due'], 2) }}
                                           </td>
                                       </tr>

                                       <tr class="*:text-gray-900 *:first:font-medium *:first:w-fit *:first:min-w-fit">

                                           <th class="px-3 py-2 bg-gray-300! text-start whitespace-nowrap ">Payable Amount

                                           </th>
                                           <td class="px-3 py-2 text-end whitespace-nowrap w-full">
                                               Tk {{ number_format(($activeInvoice['grand_total']+$activeInvoice['previous_due']), 2) }} </td>
                                       </tr>
                                       <tr class="*:text-gray-900 *:first:font-medium">
                                           <th class="px-3 py-2 text-start whitespace-nowrap">Deposit</th>
                                           <td class="px-3 py-2 text-end whitespace-nowrap w-full">
                                               {{-- Tk {{ number_format($activeInvoice['paid_amount'], 2) }} </td> --}}

                                               <input type="text" class="text-end focus-within:outline-0"
                                                   min="0" wire:model.live.debounce.1500ms="paidAmount"
                                                   wire:model.blur="paidAmount"
                                                    inputmode="decimal"
    oninput="this.value = this.value
        .replace(/[^0-9.]/g, '')
        .replace(/(\..*)\./g, '$1');"
                                                   >
                                               @error('paidAmount')
                                                   <br>
                                                   <span class="text-sm text-left text-red-600 w-full">
                                                       {{ $message }}
                                                   </span>
                                               @enderror
                                       </tr>

                                       <tr class="*:text-gray-900 *:first:font-medium">
                                           <th class="px-3 py-2 text-start whitespace-nowrap">Due</th>
                                           <td class="px-3 py-2 text-end whitespace-nowra w-fullp">
                                               Tk {{ number_format($activeInvoice['due_amount'], 2) }} </td>
                                       </tr>

                                   </tbody>
                               </table>
                           </div>
                           <div>
                               {{-- buttons  --}}
                               <hr class="my-4">
                               <div class="flex items-center justify-between gap-2">

                                   <button type="button" wire:click="paymentAction"
                                       class="flex-1 cursor-pointer bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Confirm
                                       Payment</button>
                                   <div class="relative inline-flex" x-data="{ MenuOpen: false }" x-cloak
                                       @click.outside="MenuOpen = false">
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
                                           class="absolute end-0 bottom-full z-auto w-56 overflow-hidden rounded border border-gray-300 bg-white shadow-sm"
                                           x-transition:enter="transition ease-out duration-200">
                                           {{-- @can('invoice.view')
                                               <button type="button"
                                                   class="block px-3 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-50 hover:text-gray-900"
                                                   role="menuitem">
                                                   View
                                               </button>
                                           @endcan --}}
                                           {{-- @can('invoice.edit')
                                               <button
                                                   class="block px-3 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-50 hover:text-gray-900"
                                                   role="menuitem">
                                                   Edit
                                               </button>
                                           @endcan --}}

                                           <a href="{{ route('company.invoice.download', $activeInvoice['id']) }}"
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
                               </div>
                           </div>
                       @endif
                       {{-- end invoice summry --}}
                   </div>


               </div>

               {{-- =========================== Content End Here ============================ --}}
           </div>
       </div>
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
                                               src="{{ $customeritem->profile_picture }}"
                                               alt="">
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
       <div x-cloak x-data="{ confirmModalOpen: @entangle('confirmModalOpen') }" x-show="confirmModalOpen" x-transition
           class="fixed inset-0 z-50 grid place-content-center bg-black/50 p-4" role="dialog" aria-modal="true"
           aria-labelledby="modalTitle">
           <div
               class="w-full md:w-md rounded-lg bg-white p-6 shadow-lg overflow-auto scrollbar scrollbar-thin scrollbar-transparent scrollbar-track-gray-100 scrollbar-thumb-gray-300 scrollbar-thumb-rounded-full scrollbar-track-rounded-full">
               <div class="flex items-start justify-between">
                   <h2 id="modalTitle" class="text-xl font-bold text-gray-900 sm:text-2xl">Payment</h2>

                   <button wire:click="confirmModalOpen=false" type="button"
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
                   @if ($settledinvoiceId != null)
                       <div>
                           <div role="alert" class="rounded-md border border-green-500 bg-green-50 p-4 shadow-sm">
                               <div class="flex items-start gap-4">

                                   <div class="flex-1 text-center">
                                       <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                           stroke-width="1.5" stroke="currentColor"
                                           class="-mt-0.5 mx-auto size-6 text-green-700 ">
                                           <path stroke-linecap="round" stroke-linejoin="round"
                                               d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                           </path>
                                       </svg>

                                       <strong class="block leading-tight font-medium text-green-800"> Invoice
                                           Settled
                                       </strong>


                                       <p class="mt-0.5 text-sm text-green-700">
                                           Sales Completed and Invoice Settled Successfully.
                                       </p>

                                   </div>

                               </div>
                           </div>
                           <div class="flex justify-center items-center gap-2 my-2">

                               @if ($settledinvoiceId)
                                   <a href="{{ route('company.invoice.download', $settledinvoiceId) }}"
                                       class="inline-flex items-center gap-2 rounded-sm border border-gray-600 px-8 py-3 text-gray-600 hover:bg-gray-600 hover:text-white"
                                       href="#">
                                       <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                           stroke-width="1.5" stroke="currentColor" class="size-6 mr-0.5">
                                           <path stroke-linecap="round" stroke-linejoin="round"
                                               d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
                                       </svg>
                                       <span class="text-sm font-medium"> Print Invoice </span>
                                   </a>
                               @endif
                           </div>
                       </div>
                   @elseif (is_null($customer))
                       <div>
                           <div role="alert" class="rounded-md border border-red-500 bg-red-50 p-4 shadow-sm">
                               <div class="flex items-start gap-4">

                                   <div class="flex-1 text-center">
                                       <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                           stroke-width="1.5" stroke="currentColor"
                                           class="-mt-0.5 mx-auto  size-6 text-red-700">
                                           <path stroke-linecap="round" stroke-linejoin="round"
                                               d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z">
                                           </path>
                                       </svg>



                                       <strong class="block leading-tight font-medium text-red-800"> Invoice
                                           Customer No Selected
                                       </strong>


                                       <p class="mt-0.5 text-sm text-red-700">
                                           Please select a customer for the invoice.
                                       </p>

                                   </div>

                               </div>
                           </div>

                       </div>
                   @elseif ($isStockOut)
                       <div>
                           <div role="alert" class="rounded-md border border-red-500 bg-red-50 p-4 shadow-sm">
                               <div class="flex items-start gap-4">

                                   <div class="flex-1 text-center">
                                       <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                           stroke-width="1.5" stroke="currentColor"
                                           class="-mt-0.5 mx-auto  size-6 text-red-700">
                                           <path stroke-linecap="round" stroke-linejoin="round"
                                               d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z">
                                           </path>
                                       </svg>



                                       <strong class="block leading-tight font-medium text-red-800"> Stock Out
                                           Alert
                                       </strong>


                                       <p class="mt-0.5 text-sm text-red-700">
                                           Please verify the product stock levels in your cart.
                                       </p>

                                   </div>

                               </div>
                           </div>

                       </div>
                   @elseif ($activeInvoice['due_amount'] == 0)
                       <div>
                           <div role="alert" class="rounded-md border border-red-500 bg-red-50 p-4 shadow-sm">
                               <div class="flex items-start gap-4">

                                   <div class="flex-1 text-center">
                                       <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                           stroke-width="1.5" stroke="currentColor"
                                           class="-mt-0.5 mx-auto  size-6 text-red-700">
                                           <path stroke-linecap="round" stroke-linejoin="round"
                                               d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z">
                                           </path>
                                       </svg>



                                       <strong class="block leading-tight font-medium text-red-800"> No Due
                                       </strong>


                                       <p class="mt-0.5 text-sm text-red-700">
                                           There is currently no payment due for this invoice. Please review your
                                           invoice for any outstanding payments.
                                       </p>

                                   </div>

                               </div>
                           </div>

                       </div>
                   @elseif ($checkBalance)
                       <div>
                           <div role="alert" class="rounded-md border border-red-500 bg-red-50 p-4 shadow-sm">
                               <div class="flex items-start gap-4">

                                   <div class="flex-1 text-center">
                                       <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                           stroke-width="1.5" stroke="currentColor"
                                           class="-mt-0.5 mx-auto  size-6 text-red-700">
                                           <path stroke-linecap="round" stroke-linejoin="round"
                                               d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z">
                                           </path>
                                       </svg>



                                       <strong class="block leading-tight font-medium text-red-800"> Inifuciante
                                           Balance
                                       </strong>


                                       <p class="mt-0.5 text-sm text-red-700">
                                           Please verify your balance
                                       </p>

                                   </div>

                               </div>
                           </div>

                       </div>
                   @else
                       <form x-data="{
                           radio: @entangle('radio'),
                           invoiceAmount: @js($invoiceAmount)
                       }" wire:submit.prevent="paymentAction" class="space-y-4">
                           <div class="grid gap-1">
                               <label class="text-sm font-medium">Payment Method</label>
                               <select wire:model="paymentMethod" class="p-2 border border-gray-300 rounded-lg"
                                   name="payment_method" id="">
                                   <option value="">Select Method</option>
                                   @foreach (\App\Enums\Invoice\PaymentMethod::cases() as $method)
                                       <option value="{{ $method->value }}">{{ $method->name }}</option>
                                   @endforeach
                               </select>
                           </div>
                           <!-- Radio -->
                           <div class="grid gap-1">
                               <label class="text-sm font-medium">Paid Type</label>

                               <div class="flex gap-4">
                                   <label class="flex items-center cursor-pointer">
                                       <input class="border border-transparent checked:border-gray-300" type="radio"
                                           value="full_paid" wire:model.live="radio">
                                       <span class="ml-2">Full Paid</span>
                                   </label>

                                   <label class="flex items-center cursor-pointer">
                                       <input type="radio" value="partial_paid" wire:model.live="radio">
                                       <span class="ml-2">Partial Paid</span>
                                   </label>

                                   <label class="flex items-center cursor-pointer">
                                       <input type="radio" value="full_due" wire:model.live="radio">
                                       <span class="ml-2">Full Due</span>
                                   </label>
                               </div>
                           </div>

                           <!-- Paid Amount -->
                           <div class="grid gap-1">
                               <label class="text-sm font-medium">Paid Amount</label>

                               <input type="number" step="0.01" min="0" max="{{ $invoiceAmount }}"
                                   wire:model.live.debounce.500ms="paidAmount"
                                   x-bind:disabled="radio !== 'partial_paid'"
                                   class="w-full rounded-lg border border-gray-300 p-2
               disabled:bg-gray-100 disabled:cursor-not-allowed"
                                   placeholder="Enter paid amount">

                               @error('paidAmount')
                                   <span class="text-sm text-red-600">{{ $message }}</span>
                               @enderror
                           </div>


                           <!-- Submit -->
                           <button type="submit"
                               class="w-full rounded-lg border border-indigo-600 px-12 py-3 text-sm font-medium text-indigo-600 hover:bg-indigo-500 hover:text-white">
                               Submit
                           </button>
                       </form>
                   @endif

               </div>
           </div>
       </div>
   </div>

   {{-- =========================== Page Layout End Here ============================ --}}
