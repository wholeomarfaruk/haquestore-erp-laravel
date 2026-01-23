   {{-- ======================== Page Layout Start From Here ======================== --}}
   <div x-data x-init="$store.pageName = { name: 'Manage Products', slug: 'product' }">
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
                               placeholder="Search by Name"
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
                           <button wire:click="addProductModal=true" type="button"
                               class="flex items-center gap-2  pb-1 text-gray-700 transition-colors hover:border-gray-400 hover:text-gray-900 cursor-pointer rounded border border-gray-300 px-4 py-2">
                               <span class="text-sm font-medium"> Add Product</span>
                       </div>
                   </div>
               </div>
           </div>
           <div class="overflow-x-auto rounded mx-4 px-2">
               <div class="min-w-full divide-y-2 divide-gray-200">
                   <div class="grid grid-cols-4 gap-2">
                       @if ($products->count() > 0)
                           @foreach ($products as $product)
                               <div>
                                   <div class="block relative rounded-lg p-4 shadow-lg border border-gray-200 ">
                                       {{-- <img alt="" src="{{ asset($product->product_image) }}"
                                           class="h-36 w-full rounded-md object-cover"> --}}

                                       <div class="mt-6">
                                           <dl>
                                               <div>
                                                   <dt class="sr-only">ID: </dt>

                                                   <dd class="text-sm text-gray-500"># {{ $product->id }}</dd>
                                               </div>

                                               <div>
                                                   <dt class="sr-only">Name:</dt>

                                                   <dd class="font-medium">{{ $product->name }}</dd>
                                               </div>
                                           </dl>

                                           <div class="mt-6 flex items-center gap-8 text-xs">
                                               <div class="sm:inline-flex sm:shrink-0 sm:items-center sm:gap-2">


                                                   <div class="mt-1.5 sm:mt-0">
                                                       <p class="text-gray-500">Quantity</p>

                                                       <p class="font-medium">
                                                           {{ $product?->stock . ' ' . $product?->unit_name }} </p>
                                                   </div>
                                               </div>



                                               <div class="sm:inline-flex sm:shrink-0 sm:items-center sm:gap-2">


                                                   <div class="mt-1.5 sm:mt-0">
                                                       <p class="text-gray-500">Per Unit</p>
                                                       <p class="font-medium">
                                                           {{ $product->value_per_unit . ' ' . $product->unit_name }}
                                                       </p>
                                                   </div>
                                               </div>
                                               <div class="sm:inline-flex sm:shrink-0 sm:items-center sm:gap-2">


                                                   <div class="mt-1.5 sm:mt-0">
                                                       <p class="text-gray-500">Price Per {{ $product->unit_name }}</p>

                                                       <p class="font-medium">{{ $product->price }} Tk</p>
                                                   </div>
                                               </div>
                                           </div>
                                       </div>
                                       <div class="absolute top-5 right-5 left-0 flex items-center gap-2 justify-end">


                                           <span alt="View Product"
                                               class="cursor-pointer rounded-md shadow-lg bg-sky-100 px-1 py-1 text-sky-700 dark:bg-sky-700 dark:text-sky-100">

                                               <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                   viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                   class="size-4">
                                                   <path stroke-linecap="round" stroke-linejoin="round"
                                                       d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                   <path stroke-linecap="round" stroke-linejoin="round"
                                                       d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                               </svg>



                                           </span>
                                           <span x-data
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
                                                        $wire.deleteProduct({{ $product->id }})
                                                    }
                                                })
                                            "
                                               alt="Delete"
                                               class="cursor-pointer rounded-md shadow-lg bg-red-100 px-1 py-1 text-red-700 dark:bg-red-700 dark:text-red-100">
                                               <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none"
                                                   viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                   <path stroke-linecap="round" stroke-linejoin="round"
                                                       d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                               </svg>


                                           </span>
                                           {{-- edit product icon  --}}
                                           <span wire:click="editProduct({{ $product->id }})" alt="Edit"
                                               class="cursor-pointer rounded-md shadow-lg bg-emerald-100 px-1 py-1 text-emerald-700 dark:bg-emerald-700 dark:text-emerald-100">
                                               <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none"
                                                   viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                   <path stroke-linecap="round" stroke-linejoin="round"
                                                       d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                               </svg>

                                           </span>
                                       </div>
                                   </div>
                               </div>
                           @endforeach
                       @endif

                   </div>

               </div>

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
                   @if ($viewProduct && $viewModal)
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
       <div x-cloak x-data="{ addProductModalOpen: @entangle('addProductModal') }" x-show="addProductModalOpen" x-transition
           class="fixed inset-0 z-50 grid place-content-center bg-black/50 p-4" role="dialog" aria-modal="true"
           aria-labelledby="modalTitle">
           <div
               class="w-md md:w-3xl rounded-lg bg-white p-6 shadow-lg overflow-auto scrollbar scrollbar-thin scrollbar-transparent scrollbar-track-gray-100 scrollbar-thumb-gray-300 scrollbar-thumb-rounded-full scrollbar-track-rounded-full">
               <div class="flex items-start justify-between">
                   <h2 id="modalTitle" class="text-xl font-bold text-gray-900 sm:text-2xl">Add New Product</h2>

                   <button wire:click="addProductModal=false" type="button"
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

                   <form action="#" class="space-y-4" wire:submit.prevent="addNewProduct">
                       <div class="grid grid-cols-1 gap-1">
                           <label class="block text-sm font-medium text-gray-900" for="name">Name <span
                                   class="size-6 text-red-500 mr-1.5">*</span></label>
                           <input wire:model="newPName" name="ProductName"
                               class="mt-1 w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:outline-none p-2"
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
                               <input wire:model="newPSalePrice" min="0"
                                   class="mt-1 w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:outline-none p-2"
                                   id="sale_price" type="text" placeholder="Enter Sale Price" />
                               @error('newPSalePrice')
                                   <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                               @enderror
                           </div>

                           {{-- <div class="grid grid-cols-1 gap-1">
                               <label class="block text-sm font-medium text-gray-900" for="phone">Discount
                                   Price</label>
                               <input wire:model="newPDiscountPrice" min="0"
                                   class="mt-1 w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:outline-none p-2"
                                   id="phone" type="text" placeholder="Enter Discount Price" />
                               @error('newPDiscountPrice')
                                   <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                               @enderror
                           </div> --}}
                           {{-- <div class="grid grid-cols-1 gap-1">
                               <label class="block text-sm font-medium text-gray-900" for="phone">Unit qty <span
                                       class="size-6 text-red-500 mr-1.5">*</span> </label>
                               <input wire:model="newPQuantity" disabled
                                   class="mt-1 w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:outline-none p-2 disabled:bg-gray-100"
                                   id="phone" type="number" placeholder="Enter Unit qty" />
                               @error('newPQuantity')
                                   <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                               @enderror
                           </div> --}}
                           <div class="grid grid-cols-1 gap-1">
                               <label class="block text-sm font-medium text-gray-900" for="phone">Kg Per Unit <span
                                       class="size-6 text-red-500 mr-1.5">*</span> </label>
                               <input wire:model="newKgPerUnit"
                                   class="mt-1 w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:outline-none p-2"
                                   id="phone" type="number" placeholder="Kg per 1 unit. 1x50kg" />
                               @error('newKgPerUnit')
                                   <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                               @enderror
                           </div>
                           <div class="grid grid-cols-1 gap-1">
                               <label class="block text-sm font-medium text-gray-900" for="stock_status">Stock
                                   Status <span class="size-6 text-red-500 mr-1.5">*</span> </label>
                               <select wire:model="newPStockStatus" id="stock_status"
                                   class="mt-1 w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:outline-none p-2 sm:text-sm">
                                   <option value="">Select Stock Status</option>
                                   <option value="in_stock">In Stock</option>
                                   <option value="stock_out">Stock Out</option>
                                   <option value="low_stock">Low Stock</option>
                               </select>
                               @error('newPStockStatus')
                                   <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                               @enderror
                           </div>



                       </div>
                       {{-- <div class="grid grid-cols-2 gap-1">

                           <div class="grid grid-cols-1 gap-1">
                               <label class="block text-sm font-medium text-gray-900" for="phone">Measeure By<span
                                       class="size-6 text-red-500 mr-1.5">*</span> </label>
                               <select wire:model="newPunit" disabled
                                   class="mt-1 w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:outline-none p-2 sm:text-sm disabled:bg-gray-100">
                                   <option value="">Select Unit</option>
                                   @foreach (\App\Enums\Product\Unit::cases() as $unit)
                                       <option value="{{ $unit->value }}">{{ $unit->name }}</option>
                                   @endforeach

                               </select>
                               @error('newPunit')
                                   <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                               @enderror
                           </div>

                       </div> --}}


                       <div>
                           <label class="block text-sm font-medium text-gray-900"
                               for="discription">Discription</label>

                           <textarea wire:model="newPDescription"
                               class="mt-1 w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:outline-none p-2"
                               id="discription" rows="4" placeholder="Enter Discription"></textarea>
                           @error('newPDescription')
                               <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                           @enderror
                       </div>



                       {{-- <div class="flex flex-row gap-1 mt-2" wire:key="new-product-image-container">
                           @if ($newPImage && $newPImage?->temporaryUrl())
                               <div class="grid grid-cols-1 gap-1 flex-1">
                                   <div class="w-full">
                                       <img src="{{ $newPImage?->temporaryUrl() }}" alt="Product Image Preview"
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

                                   <span class="mt-4 font-medium"> Upload Product Image <span
                                           class="size-6 text-red-500 mr-1.5">*</span> </span>

                                   <span
                                       class="mt-2 inline-block rounded border border-gray-200 bg-gray-50 px-3 py-1.5 text-center text-xs font-medium text-gray-700 shadow-sm hover:bg-gray-100">
                                       Browse file
                                   </span>
                                   @error('newPImage')
                                       <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                   @enderror

                                   <input wire:key="new-product-image" wire:model.live="newPImage" type="file"
                                       id="NewFile" class="sr-only">
                               </label>
                           </div>
                       </div> --}}





                       <button type="submit"
                           class="block w-full rounded-lg border border-indigo-600 bg-white px-12 py-3 text-sm font-medium text-indigo-600 transition-colors hover:bg-indigo-500 hover:text-white cursor-pointer">
                           Submit
                       </button>
                   </form>

               </div>
           </div>
       </div>

       <div x-cloak x-data="{ editProductModalOpen: @entangle('editProductModal') }" x-show="editProductModalOpen" x-transition
           class="fixed inset-0 z-50 grid place-content-center bg-black/50 p-4" role="dialog" aria-modal="true"
           aria-labelledby="modalTitle">
           <div
               class="w-md md:w-3xl rounded-lg bg-white p-6 shadow-lg overflow-auto scrollbar scrollbar-thin scrollbar-transparent scrollbar-track-gray-100 scrollbar-thumb-gray-300 scrollbar-thumb-rounded-full scrollbar-track-rounded-full">
               <div class="flex items-start justify-between">
                   <h2 id="modalTitle" class="text-xl font-bold text-gray-900 sm:text-2xl">Edit Product</h2>

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
                           <input wire:model="editProductName" name="ProductName"
                               class="mt-1 w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:outline-none p-2"
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
                           {{-- <div class="grid grid-cols-1 gap-1">
                               <label class="block text-sm font-medium text-gray-900" for="phone">Unit qty <span
                                       class="size-6 text-red-500 mr-1.5">*</span> </label>
                               <input wire:model="editProductQuantity" disabled
                                   class="mt-1 w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:outline-none p-2 disabled:bg-gray-100"
                                   id="phone" type="number" placeholder="Enter Unit qty" />
                               @error('editPQuantity')
                                   <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                               @enderror
                           </div> --}}
                           <div class="grid grid-cols-1 gap-1">
                               <label class="block text-sm font-medium text-gray-900" for="phone">Kg Per Unit <span
                                       class="size-6 text-red-500 mr-1.5">*</span> </label>
                               <input wire:model="editKgPerUnit"
                                   class="mt-1 w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:outline-none p-2"
                                   id="phone" type="text" placeholder="Kg per 1 unit. 1x50kg" />
                               @error('editKgPerUnit')
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
                       {{-- <div class="grid grid-cols-2 gap-1">

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

                       </div> --}}


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



                       {{-- <div class="flex flex-row gap-1" wire:key="edit-product-image-container">
                           @if ($editProductImage && method_exists($editProductImage, 'temporaryUrl'))
                               <div class="grid grid-cols-1 gap-1 flex-1">
                                   <div class="w-full">
                                       <img src="{{ $editProductImage?->temporaryUrl() }}"
                                           alt="Product Image Preview" class="w-full h-auto rounded-lg shadow-sm">
                                   </div>
                               </div>
                           @else
                               <div class="grid grid-cols-1 gap-1 flex-1">
                                   <div class="w-full">
                                       <img src="{{ asset('storage/' . $editViewProductImage) }}"
                                           alt="Product Image Preview" class="w-full h-auto rounded-lg shadow-sm">
                                   </div>
                               </div>
                           @endif
                           <div class="grid grid-cols-1 gap-1 flex-1 ">
                               <label for="EditFile"
                                   class="flex flex-col items-center rounded-lg border border-gray-300 p-4 text-gray-900 shadow-sm sm:p-6">
                                   <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                       stroke-width="1.5" stroke="currentColor" class="size-6">
                                       <path stroke-linecap="round" stroke-linejoin="round"
                                           d="M7.5 7.5h-.75A2.25 2.25 0 0 0 4.5 9.75v7.5a2.25 2.25 0 0 0 2.25 2.25h7.5a2.25 2.25 0 0 0 2.25-2.25v-7.5a2.25 2.25 0 0 0-2.25-2.25h-.75m0-3-3-3m0 0-3 3m3-3v11.25m6-2.25h.75a2.25 2.25 0 0 1 2.25 2.25v7.5a2.25 2.25 0 0 1-2.25 2.25h-7.5a2.25 2.25 0 0 1-2.25-2.25v-.75">
                                       </path>
                                   </svg>

                                   <span class="mt-4 font-medium"> Upload Product Image <span
                                           class="size-6 text-red-500 mr-1.5">*</span> </span>

                                   <span
                                       class="mt-2 inline-block rounded border border-gray-200 bg-gray-50 px-3 py-1.5 text-center text-xs font-medium text-gray-700 shadow-sm hover:bg-gray-100">
                                       Browse file
                                   </span>
                                   @error('editProductImage')
                                       <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                   @enderror
                                   <input wire:key="edit-product-image" wire:model.live="editProductImage"
                                       type="file" id="EditFile" class="sr-only">
                               </label>
                           </div>
                       </div> --}}





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
