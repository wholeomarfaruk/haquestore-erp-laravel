   {{-- ======================== Page Layout Start From Here ======================== --}}
   <div x-data x-init="$store.pageName = { name: 'Manage Stock', slug: 'stock' }">
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

                   </div>
               </div>
           </div>

           <div class="overflow-x-auto rounded border border-gray-300 shadow-sm mx-4">
               <table class="min-w-full divide-y-2 divide-gray-200">
                   <thead class="ltr:text-left rtl:text-right">
                       <tr class="*:font-medium *:text-gray-900">
                           <th class="px-3 py-2 whitespace-nowrap flex justify-start gap-3 items-center"> <input
                                   type="checkbox" class="my-0.5 size-5 rounded border-gray-300 shadow-sm"> Product</th>


                           <th class="px-3 py-2 whitespace-nowrap">Status</th>
                          
                           <th class="px-3 py-2 whitespace-nowrap">Stock</th>
                           <th class="px-3 py-2 whitespace-nowrap text-center">Action</th>
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
                                           <img alt="" src="{{ asset('storage/' . $product->image) }}"
                                               class="size-12 rounded-lg object-cover sm:size-[52px]">

                                       </div>
                                       <div>
                                           <p class="font-bold mb-0 text-sm/2">{{ $product->name }}</p>
                                           <span class="text-xs text-gray-400">#{{ $product->id }}</span><br>
                                           <span
                                               class="text-xs text-gray-400">{{ $product->updated_at->format('d-m-Y h:i A') }}</span>
                                       </div>
                                   </td>

                                   <td class="px-3 py-2 whitespace-nowrap">
                                       @if ($product->stock_status == \App\Enums\Product\StockStatus::IN_STOCK->value)
                                           <span
                                               class="inline-flex items-center justify-center rounded-full bg-emerald-100 px-2.5 py-0.5 text-emerald-700 dark:bg-emerald-700 dark:text-emerald-100">
                                               <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-1"
                                                   fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                   stroke="currentColor">
                                                   <path stroke-linecap="round" stroke-linejoin="round"
                                                       d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                               </svg>
                                               <p class="text-sm whitespace-nowrap">In Stock</p>
                                           </span>
                                       @elseif($product->stock_status == \App\Enums\Product\StockStatus::STOCK_OUT->value)
                                           <span
                                               class="inline-flex items-center justify-center rounded-full bg-red-100 px-2.5 py-0.5 text-red-700 dark:bg-red-700 dark:text-red-100">

                                               <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                   viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                   class="size-4 mr-1">
                                                   <path stroke-linecap="round" stroke-linejoin="round"
                                                       d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                                               </svg>

                                               <p class="text-sm whitespace-nowrap">Stock Out</p>
                                           </span>
                                       @elseif($product->stock_status == \App\Enums\Product\StockStatus::LOW_STOCK->value)
                                           <span
                                               class="inline-flex items-center justify-center rounded-full bg-red-100 px-2.5 py-0.5 text-red-700 dark:bg-red-700 dark:text-red-100">

                                               <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                   viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                   class="size-4 mr-1">
                                                   <path stroke-linecap="round" stroke-linejoin="round"
                                                       d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                                               </svg>

                                               <p class="text-sm whitespace-nowrap">Low Stock</p>
                                           </span>
                                       @endif

                                   </td>
                                   
                                   <td class="px-3 py-2 whitespace-nowrap">
                                       <span
                                           class="inline-flex items-center justify-center rounded-full bg-red-100 px-2.5 py-0.5 text-red-700 dark:bg-red-700 dark:text-red-100">
                                           <p class="text-sm whitespace-nowrap">{{ $product->unit_value }} Unit & {{$product->stock." " .$product->unit_name }}</p>

                                       </span>
                                       <p class="text-xs text-gray-400">Per Unit
                                           {{ $product->value_per_unit . ' ' . $product->unit_name }}</p>

                                   </td>
                                   <td class="px-3 py-2 whitespace-nowrap">
                                       <div class="flex items-center justify-center gap-2">

                                           <button wire:click="editProduct({{ $product->id }})"
                                               class="text-green-500 hover:text-green-600 flex gap-1 cursor-pointer">
                                               <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                   viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                   class="size-6">
                                                   <path stroke-linecap="round" stroke-linejoin="round"
                                                       d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                               </svg>
                                               UPDATE
                                           </button>
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

       <div x-cloak x-data="{ editProductModalOpen: @entangle('editProductModal') }" x-show="editProductModalOpen"  x-transition
           class="fixed inset-0 z-50 grid place-content-center bg-black/50 p-4" role="dialog" aria-modal="true"
           aria-labelledby="modalTitle">
           <div wire:click.outside="editProductModal=false"
               class="w-md md:w-3xl rounded-lg bg-white p-6 shadow-lg overflow-auto scrollbar scrollbar-thin scrollbar-transparent scrollbar-track-gray-100 scrollbar-thumb-gray-300 scrollbar-thumb-rounded-full scrollbar-track-rounded-full">
               <div class="flex items-start justify-between">
                   <h2 id="modalTitle" class="text-xl font-bold text-gray-900 sm:text-2xl">Update Stock - #{{ $editProductId }}</h2>

                   <button wire:click="editProductModal=false" type="button"
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

                   <form action="#" class="space-y-4" wire:submit.prevent="updateNewProduct">
                       <input type="hidden" name="product_id" wire:model="editProductId">
                       <div class="grid grid-cols-1 gap-1">
                           <label class="block text-sm font-medium text-gray-900" for="name">Name <span
                                   class="size-6 text-red-500 mr-1.5">*</span></label>
                           <input wire:model="editProductName" name="ProductName" disabled
                               class="mt-1 w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:outline-none p-2 disabled:bg-gray-50 disabled:cursor-not-allowed"
                               id="name" type="text" placeholder="Enter Product Name" />
                           @error('newPName')
                               <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                           @enderror
                       </div>
                        <div class="grid grid-cols-3 gap-1">
                           {{-- <div class="grid grid-cols-1 gap-1">
                               <label class="block text-sm font-medium text-gray-900" for="purchase_price">Purchase
                                   Price</label>
                               <input wire:model="newPPurchasePrice" min="0"
                                   class="mt-1 w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:outline-none p-2"
                                   id="purchase_price" type="number" pattern="[0-9]"
                                   placeholder="Enter Purchase Price" />
                               @error('newPPurchasePrice')
                                   <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                               @enderror
                           </div> --}}
                           <div class="grid grid-cols-1 gap-1">
                               <label class="block text-sm font-medium text-gray-900" for="sale_price">Sale Price
                                   <span class="size-6 text-red-500 mr-1.5">*</span> </label>
                               <input wire:model="editProductSalePrice" min="0"
                                   class="mt-1 w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:outline-none p-2"
                                   id="sale_price" type="text" placeholder="Enter Sale Price" />
                               @error('editPSalePrice')
                                   <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                               @enderror
                           </div>

                           {{-- <div class="grid grid-cols-1 gap-1">
                               <label class="block text-sm font-medium text-gray-900" for="phone">Discount
                                   Price</label>
                               <input wire:model="editPDiscountPrice" min="0"
                                   class="mt-1 w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:outline-none p-2"
                                   id="phone" type="text" placeholder="Enter Discount Price" />
                               @error('editPDiscountPrice')
                                   <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                               @enderror
                           </div> --}}
                           <div class="grid grid-cols-1 gap-1">
                               <label class="block text-sm font-medium text-gray-900" for="phone">Unit qty <span
                                       class="size-6 text-red-500 mr-1.5">*</span> </label>
                               <input wire:model="editProductQuantity"
                                   class="mt-1 w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:outline-none p-2"
                                   id="phone" type="number" placeholder="Enter Unit qty" />
                               @error('editPQuantity')
                                   <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                               @enderror
                           </div>
                                  <div class="grid grid-cols-1 gap-1">
                               <label class="block text-sm font-medium text-gray-900" for="phone">Kg Per Unit <span
                                       class="size-6 text-red-500 mr-1.5">*</span> </label>
                               <input wire:model="editKgPerUnit"
                                   class="mt-1 w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:outline-none p-2"
                                   id="phone" type="text"  placeholder="Kg per 1 unit. 1x50kg" />
                               @error('editKgPerUnit')
                                   <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                               @enderror
                           </div>


                       </div>
                       <div class="grid grid-cols-2 gap-1">

                           <div class="grid grid-cols-1 gap-1">
                               <label class="block text-sm font-medium text-gray-900" for="phone">Measeure By<span
                                       class="size-6 text-red-500 mr-1.5">*</span> </label>
                               <select wire:model="editProductUnit" disabled
                                   class="mt-1 w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:outline-none p-2 sm:text-sm disabled:bg-gray-100">
                                   <option value="">Select Unit</option>
                                   @foreach (\App\Enums\Product\Unit::cases() as $unit)
                                       <option value="{{ $unit->value }}">{{ $unit->name }}</option>
                                   @endforeach

                               </select>
                               @error('editPunit')
                                   <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                               @enderror
                           </div>
                           <div class="grid grid-cols-1 gap-1">
                               <label class="block text-sm font-medium text-gray-900" for="stock_status">Stock
                                   Status <span class="size-6 text-red-500 mr-1.5">*</span> </label>
                               <select wire:model="editProductStockStatus" id="stock_status"
                                   class="mt-1 w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:outline-none p-2 sm:text-sm">
                                   <option value="">Select Stock Status</option>
                                   <option value="in_stock">In Stock</option>
                                   <option value="stock_out">Stock Out</option>
                                   <option value="low_stock">Low Stock</option>
                               </select>
                               @error('editPStockStatus')
                                   <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                               @enderror
                           </div>

                       </div>


                       <div>
                           <label class="block text-sm font-medium text-gray-900"
                               for="discription">Discription</label>

                           <textarea wire:model="editProductDescription"
                               class="mt-1 w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:outline-none p-2"
                               id="discription" rows="4" placeholder="Enter Discription"></textarea>
                           @error('newPDescription')
                               <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
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
   </div>


   {{-- =========================== Page Layout End Here ============================ --}}
