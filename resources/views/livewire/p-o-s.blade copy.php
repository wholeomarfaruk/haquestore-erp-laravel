   {{-- ======================== Page Layout Start From Here ======================== --}}
   <div x-data x-init="$store.pageName = { name: 'Sales Point', slug: 'pos' }">
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
           <div class="grid grid-cols-4 gap-2">
               <div class="col-span-3 p-2">
                   <div x-data="{ filter: false }" class="flex items-center justify-between gap-2 relative my-3 mx-4 px-2">
                       <div class="">
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
                                       class="mt-0.5 h-10 w-full rounded border-gray-300 pr-10 pl-2 shadow-sm sm:text-sm focus-within:outline-0.5 focus-within:outline-blue-400">

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
                   <div class="overflow-x-auto rounded mx-4 px-2">
                       <div class="min-w-full divide-y-2 divide-gray-200">
                           <div class="grid grid-cols-4 gap-2">
                               @if ($products->count() > 0)
                                   @foreach ($products as $product)
                                       <div title="{{ $product->name }}" comment="Product Card">
                                           <div
                                               class="block relative rounded-lg p-4 shadow-lg border border-gray-200 ">
                                               <img alt="" src="{{ asset('storage/' . $product->image) }}"
                                                   class="h-36 w-full rounded-md object-cover {{ $product->stock_status == \App\Enums\Product\StockStatus::STOCK_OUT->value || $product->unit_value == 0 ? 'sepia' : '' }}">

                                               <div class="">
                                                   <dl>
                                                       <span>
                                                           <dt class="sr-only">Qty: </dt>

                                                           <span class="text-sm text-gray-500" title="Quantity">
                                                               {{ $product->unit_value . ' ' . $product->unit_name }}</span>
                                                       </span>
                                                       <span class="divider size-6 text-gray-500">|</span>
                                                       @if ($product->discount_price > 0)
                                                           <span>
                                                               <dt class="sr-only">Price: </dt>

                                                               <del class="text-[10px] text-gray-500"
                                                                   title="Regular Price: {{ $product->price . ' Tk' }}">
                                                                   {{ $product->price }}</del>
                                                           </span>

                                                           <span>
                                                               <dt class="sr-only">Discount Price: </dt>

                                                               <span class="text-sm text-gray-500"
                                                                  
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
                                                               class="font-medium {{ $product->stock_status == \App\Enums\Product\StockStatus::STOCK_OUT->value || $product->unit_value == 0 ? 'text-gray-400' : '' }}">
                                                               {{ $product->name }}</dd>
                                                       </div>
                                                   </dl>

                                                   <div class="mt-6 flex items-center justify-between gap-8 text-xs">



                                                       <div
                                                           class="sm:inline-flex sm:shrink-0 sm:items-center sm:gap-2 ">


                                                           <div>
                                                               <label for="Quantity" class="sr-only"> Quantity
                                                               </label>

                                                               <div
                                                                   class="flex items-center rounded-lg border border-gray-200 px-2">


                                                                   <button type="button"
                                                                       {{ $product->stock_status == \App\Enums\Product\StockStatus::STOCK_OUT->value || $product->unit_value == 0 ? 'disabled' : '' }}
                                                                       class=" text-gray-600  rounded-full text-center transition hover:text-white hover:bg-gray-600 cursor-pointer disabled:bg-gray-200 disabled:text-gray-50 disabled:cursor-not-allowed">
                                                                       <svg xmlns="http://www.w3.org/2000/svg"
                                                                           fill="none" viewBox="0 0 24 24"
                                                                           stroke-width="1.5" stroke="currentColor"
                                                                           class="size-6">
                                                                           <path stroke-linecap="round"
                                                                               stroke-linejoin="round"
                                                                               d="M15 12H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                                       </svg>

                                                                   </button>

                                                                   <input type="number" id="Quantity"
                                                                       wire:model.defer="qtyInput.{{ $product->id }}"
                                                                       {{ $product->stock_status == \App\Enums\Product\StockStatus::STOCK_OUT->value || $product->unit_value == 0 ? 'disabled' : '' }}
                                                                       value="1"
                                                                       class="h-10 w-8 border-transparent text-center [-moz-appearance:textfield] sm:text-sm [&amp;::-webkit-inner-spin-button]:m-0 [&amp;::-webkit-inner-spin-button]:appearance-none [&amp;::-webkit-outer-spin-button]:m-0 [&amp;::-webkit-outer-spin-button]:appearance-none  disabled:text-gray-50 disabled:cursor-not-allowed">

                                                                   <button type="button"
                                                                       {{ $product->stock_status == \App\Enums\Product\StockStatus::STOCK_OUT->value || $product->unit_value == 0 ? 'disabled' : '' }}
                                                                       class=" text-gray-600  rounded-full text-center transition hover:text-white hover:bg-gray-600 cursor-pointer disabled:bg-gray-200 disabled:text-gray-50 disabled:cursor-not-allowed">
                                                                       <svg xmlns="http://www.w3.org/2000/svg"
                                                                           fill="none" viewBox="0 0 24 24"
                                                                           stroke-width="1.5" stroke="currentColor"
                                                                           class="size-6">
                                                                           <path stroke-linecap="round"
                                                                               stroke-linejoin="round"
                                                                               d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                                       </svg>

                                                                   </button>
                                                               </div>
                                                           </div>
                                                       </div>

                                                       <div
                                                           class="sm:inline-flex sm:shrink-0 sm:items-center sm:gap-2">

                                                           <button type="button"
                                                               wire:click="addToCart({{ $product->id }})"
                                                               {{ $product->stock_status == \App\Enums\Product\StockStatus::STOCK_OUT->value || $product->unit_value == 0 ? 'disabled' : '' }}
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
                                               </div>
                                               <div
                                                   class="absolute top-5 right-5 left-5 flex items-center gap-2 justify-between">
                                                   <div>
                                                       <span
                                                           class="inline-flex items-center justify-center rounded-full bg-black opacity-50 px-2.5 py-0.5 text-white">
                                                           <p class="text-sm whitespace-nowrap">#{{ $product->id }}
                                                           </p>
                                                       </span>
                                                   </div>
                                                   <div>
                                                       @if ($product->stock_status == \App\Enums\Product\StockStatus::STOCK_OUT->value || $product->unit_value == 0)
                                                           <span
                                                               class="inline-flex items-center justify-center rounded-full bg-red-100 px-2.5 py-0.5 text-red-700 dark:bg-red-700 dark:text-red-100">

                                                               <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                   viewBox="0 0 24 24" stroke-width="1.5"
                                                                   stroke="currentColor" class="size-4 mr-1">
                                                                   <path stroke-linecap="round"
                                                                       stroke-linejoin="round"
                                                                       d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                                               </svg>




                                                               <p class="text-sm whitespace-nowrap">Stock Out</p>
                                                           </span>
                                                       @elseif (false)
                                                           <span
                                                               class="inline-flex items-center justify-center rounded-full bg-emerald-100 px-2.5 py-0.5 text-emerald-700 dark:bg-emerald-700 dark:text-emerald-100">
                                                               <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                   viewBox="0 0 24 24" stroke-width="1.5"
                                                                   stroke="currentColor" class="-ms-1 me-1.5 size-4">
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
                                   @endforeach
                               @endif
                           </div>
                       </div>
                   </div>
               </div>
               {{-- add to cart  --}}
               <div class="col-span-1 border-l border-gray-300 min-h-screen p-2">
                   <div>
                       <p class="font-semibold text-lg">{{ $activeInvoice?->invoice_id ?? 'No Active Invoice' }}</p>
                       <!-- Slider main container -->
                       <section id="image-carousel" class="splide" aria-label="Beautiful Images">
                           <div class="splide__track">
                               <ul class="splide__list">
                                   @if ($activeInvoice)
                                       <li class="splide__slide ">
                                           <div
                                               class="flex gap-2 my-2 rounded-lg border border-gray-200 p-2 bg-emerald-200">
                                               <div class="flex-1">
                                                   <p class="font-bold text-[10px]">{{ $activeInvoice->invoice_id }}
                                                   </p>
                                                   <p class="  text-sm">Omar Faruk</p>
                                                   <p class="text-sm text-gray-500">+88 01710-123456</p>
                                               </div>

                                           </div>
                                       </li>
                                   @endif
                                   @foreach ($drafts as $draftinv)
                                       <li class="splide__slide" wire:click="setActiveInvoice({{ $draftinv->id }})">
                                           <div class="flex gap-2 my-2 rounded-lg border border-gray-200 p-2">
                                               {{-- <div>
                                               <img class="w-12 h-12 rounded-full border border-gray-200"
                                                   src="{{ asset('storage/products/5945e0d0-6125-48d6-bbe4-62c2327b29f7.jpg') }}"
                                                   alt="">
                                           </div> --}}
                                               <div class="flex-1">
                                                   <p class="font-bold text-[10px]">{{ $draftinv->invoice_id }}</p>
                                                   <p class="  text-sm">Omar Faruk</p>
                                                   <p class="text-sm text-gray-500">+88 01710-123456</p>
                                               </div>

                                           </div>
                                       </li>
                                   @endforeach
                               </ul>
                           </div>
                       </section>





                       <hr>
                       {{-- customer info --}}
                       @if ($customer)
                           <div class="flex gap-2 my-2 rounded-lg border border-gray-200 p-2">
                               <div>
                                   <img class="w-12 h-12 rounded-full border border-gray-200"
                                       src="{{ asset('storage/products/5945e0d0-6125-48d6-bbe4-62c2327b29f7.jpg') }}"
                                       alt="">
                               </div>
                               <div class="flex-1">
                                   <p class="font-semibold">Omar Faruk</p>
                                   <p class="text-sm text-gray-500">+88 01710-123456</p>
                               </div>
                               <div>
                                   @if ($customer && $customer->balance >= 0)
                                       <span
                                           class="inline-flex items-center justify-center rounded-full bg-emerald-100 px-2.5 py-0.5 text-emerald-700 dark:bg-emerald-700 dark:text-emerald-100">

                                           <svg xmlns="http://www.w3.org/2000/svg" class="size-6 -ms-1 me-1.5"
                                               fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                               stroke="currentColor" class="size-6">
                                               <path stroke-linecap="round" stroke-linejoin="round"
                                                   d="m8.25 7.5.415-.207a.75.75 0 0 1 1.085.67V10.5m0 0h6m-6 0h-1.5m1.5 0v5.438c0 .354.161.697.473.865a3.751 3.751 0 0 0 5.452-2.553c.083-.409-.263-.75-.68-.75h-.745M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                           </svg>

                                           <p class="text-sm whitespace-nowrap">{{ $customer && $customer->balance }}
                                           </p>
                                           <button wire:click="getCustomerBal({{ $customer && $customer->id }})"
                                               class="cursor-pointer">
                                               <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-1 ml-2"
                                                   fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                   stroke="currentColor">
                                                   <path stroke-linecap="round" stroke-linejoin="round"
                                                       d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                               </svg>

                                           </button>
                                       </span>
                                   @elseif($customer && $customer->balance < 0)
                                       <span
                                           class="inline-flex items-center justify-center rounded-full bg-red-100 px-2.5 py-0.5 text-red-700 dark:bg-red-700 dark:text-red-100">
                                           <svg xmlns="http://www.w3.org/2000/svg" class="size-4 ml-1 mr-1.5"
                                               fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                               stroke="currentColor">
                                               <path stroke-linecap="round" stroke-linejoin="round"
                                                   d="m8.25 7.5.415-.207a.75.75 0 0 1 1.085.67V10.5m0 0h6m-6 0h-1.5m1.5 0v5.438c0 .354.161.697.473.865a3.751 3.751 0 0 0 5.452-2.553c.083-.409-.263-.75-.68-.75h-.745M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                           </svg>


                                           <p class="text-sm whitespace-nowrap">{{ $customer && $customer->balance }}
                                           </p>
                                           <button wire:click="getCustomerBal({{ $customer && $customer->id }})"
                                               class="cursor-pointer">
                                               <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-1 ml-2"
                                                   fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                   stroke="currentColor">
                                                   <path stroke-linecap="round" stroke-linejoin="round"
                                                       d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                               </svg>

                                           </button>
                                       </span>
                                   @endif

                               </div>
                           </div>
                       @else
                           <div class="flex justify-end my-2">
                               <button wire:click="registerModal=true" type="button"
                                   class="flex items-center gap-2  pb-1 text-gray-700 transition-colors hover:border-gray-400 hover:text-gray-900 cursor-pointer rounded border border-gray-300 px-4 py-2">
                                   <span class="text-sm font-medium"> Add Customer</span>
                               </button>
                           </div>

                       @endif
                       {{-- end customer info --}}
                       {{-- start invoice items --}}
                       <ul>

                           @if ($activeInvoice && $activeInvoice->items->count() > 0)
                               {{-- @dd($activeInvoice->items->count()) --}}
                               @foreach ($activeInvoice->items as $item)
                                   <li wire:key="invoice-item-{{ $item->id }}">
                                       <div class="flex items-center gap-2 p-2 rounded-lg border border-gray-200 mb-3">
                                           <div class="">
                                               <img class="h-20 w-18 rounded-lg"
                                                   src="{{ asset('storage/' . $item->product->image) }}"
                                                   alt="">
                                           </div>
                                           <div class="flex-1">
                                               <p class="font-semibold">{{ $item->product->name }}</p>

                                               <div class="text-gray-500 flex justify-between items-center gap-2">
                                                   <div class="flex justify-start items-center gap-1">
                                                       <span class="text-gray-500 flex items-center gap-1">
                                                           <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                               viewBox="0 0 24 24" stroke-width="1.5"
                                                               stroke="currentColor" class="size-4">
                                                               <path stroke-linecap="round" stroke-linejoin="round"
                                                                   d="m8.25 7.5.415-.207a.75.75 0 0 1 1.085.67V10.5m0 0h6m-6 0h-1.5m1.5 0v5.438c0 .354.161.697.473.865a3.751 3.751 0 0 0 5.452-2.553c.083-.409-.263-.75-.68-.75h-.745M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                           </svg>


                                                           {{ $item->regular_price }}
                                                       </span>
                                                       <span class="text-gray-500">x</span>

                                                       <span class="text-gray-500">{{ $item->unit_qty }} =</span>
                                                   </div>
                                                   <div>
                                                       <span title="sub total"
                                                           class="font-bold flex justify-start items-center">
                                                           <span class=" flex items-center">


                                                               {{ $item->total }}
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
                                                           wire:click="removeFromCart({{ $item->id }})">
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
                                                           <div
                                                               class="flex items-center rounded-lg border border-gray-200 px-2">
                                                               <button type="button" {{-- Call a Livewire method directly --}}
                                                                   wire:click="updateQty({{ $item->product->id }}, 'decrease')"
                                                                   class="text-gray-600 rounded-full text-center transition hover:text-white hover:bg-gray-600 disabled:opacity-50">
                                                                   <svg xmlns="http://www.w3.org/2000/svg"
                                                                       fill="none" viewBox="0 0 24 24"
                                                                       stroke-width="1.5" stroke="currentColor"
                                                                       class="size-4">
                                                                       <path stroke-linecap="round"
                                                                           stroke-linejoin="round"
                                                                           d="M15 12H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                                   </svg>
                                                               </button>

                                                               <input type="number" {{-- Livewire updates the server as the user types --}}
                                                                   wire:model.live.debounce.500ms="qtyInput.{{ $item->product->id }}"
                                                                   value="{{ $item->unit_qty }}"
                                                                   class="h-6 w-14 border-transparent text-center sm:text-sm appearance-none"
                                                                   min="1">

                                                               <button type="button"
                                                                   wire:click="updateQty({{ $item->product->id }}, 'increase')"
                                                                   class="text-gray-600 rounded-full text-center transition hover:text-white hover:bg-gray-600 disabled:opacity-50">
                                                                   <svg xmlns="http://www.w3.org/2000/svg"
                                                                       fill="none" viewBox="0 0 24 24"
                                                                       stroke-width="1.5" stroke="currentColor"
                                                                       class="size-4">
                                                                       <path stroke-linecap="round"
                                                                           stroke-linejoin="round"
                                                                           d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
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
                       @if ($activeInvoice && $activeInvoice->items->count() > 0)
                           <div class="overflow-x-auto">
                               <hr class="my-4">
                               <table class="min-w-full divide-y-2 divide-gray-200">

                                   <tbody class="divide-y divide-gray-200 *:even:bg-gray-50">
                                       <tr class="*:text-gray-900 *:first:font-medium">

                                           <th class="px-3 py-2 text-start whitespace-nowrap">Sub Total</th>
                                           <td class="px-3 py-2 text-end whitespace-nowrap">
                                               {{ $activeInvoice->total }}</td>
                                       </tr>

                                       <tr class="*:text-gray-900 *:first:font-medium">
                                           <th class="px-3 py-2 text-start whitespace-nowrap">Discount</th>
                                           <td class="px-3 py-2 text-end whitespace-nowrap">
                                               {{ $activeInvoice->discount_amount }}</td>
                                       </tr>
                                       <tr class="*:text-gray-900 *:first:font-medium">
                                           <th class="px-3 py-2 text-start whitespace-nowrap">Paid</th>
                                           <td class="px-3 py-2 text-end whitespace-nowrap">
                                               {{ $activeInvoice->paid_amount }}</td>
                                       </tr>

                                       <tr class="*:text-gray-900 *:first:font-medium">
                                           <th class="px-3 py-2 text-start whitespace-nowrap">Due</th>
                                           <td class="px-3 py-2 text-end whitespace-nowrap">
                                               {{ $activeInvoice->due_amount }}</td>
                                       </tr>

                                   </tbody>
                               </table>
                           </div>
                           <div>
                               <hr class="my-4">
                               <div class="flex items-center justify-between gap-2">
                                   <button type="button" wire:click="payInvoice"
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
                               </div>
                           </div>
                       @endif
                       {{-- end invoice summry --}}
                   </div>
               </div>
           </div>
           {{-- =========================== Content End Here ============================ --}}
       </div>
   </div>
   {{-- =========================== Page Layout End Here ============================ --}}
   @push('scripts')
       <script>
           document.addEventListener('livewire:init', function() {
               let splide;

               const initSplide = () => {
                   // If already exists, destroy it first to prevent memory leaks
                   if (splide) splide.destroy();

                   const el = document.querySelector('#image-carousel');
                   if (el) {
                       splide = new Splide('#image-carousel', {
                           perPage: 2,
                           gap: '0.7rem',
                           pagination: false,
                           arrows: true,
                           // Link custom arrows
                           classes: {
                               arrows: 'splide__arrows your-class-arrows',
                               arrow: 'splide__arrow your-class-arrow',
                               prev: 'splide__arrow--prev !-left-5',
                               {{-- Tailwind: Move left --}}
                               next: 'splide__arrow--next !-right-5',
                               {{-- Tailwind: Move right --}}
                           },
                       }).mount();
                   }
               };

               // Initial Load
               initSplide();

               // Re-init after EVERY Livewire update (Add to cart, qty change, etc.)
               Livewire.hook('morph.updated', ({
                   component
               }) => {
                   initSplide();
               });
           });
       </script>
   @endpush
