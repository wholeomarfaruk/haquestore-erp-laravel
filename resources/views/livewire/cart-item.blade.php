<div>
    <li>
        <div class="flex items-center gap-2 p-2 rounded-lg border border-gray-200 mb-3">
            <div class="">
                <img class="h-20 w-18 rounded-lg" src="{{ asset('storage/' . $item->product->image) }}" alt="">
            </div>
            <div class="flex-1">
                <p class="font-semibold">{{ $item->product->name }}</p>

                <div class="text-gray-500 flex justify-between items-center gap-2">
                    <div class="flex justify-start items-center gap-1">
                        <span class="text-gray-500 flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m8.25 7.5.415-.207a.75.75 0 0 1 1.085.67V10.5m0 0h6m-6 0h-1.5m1.5 0v5.438c0 .354.161.697.473.865a3.751 3.751 0 0 0 5.452-2.553c.083-.409-.263-.75-.68-.75h-.745M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>


                            {{ $item->regular_price }}
                        </span>
                        <span class="text-gray-500">x</span>

                        <span class="text-gray-500">{{ $item->unit_qty }} =</span>
                    </div>
                    <div>
                        <span title="sub total" class="font-bold flex justify-start items-center">
                            <span class=" flex items-center">


                                {{ $item->total }}
                            </span>
                        </span>
                    </div>
                </div>


                <div class="flex justify-between items-center gap-2">
                    <div>
                        <button class="cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="size-4 text-indigo-400">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                            </svg>


                        </button>
                        <button title="Remove" class="cursor-pointer" wire:click="removeFromCart({{ $item->id }})">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-4 text-red-400">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                            </svg>



                        </button>
                    </div>
                    <div>
                        <div class="flex-1">
                            {{-- Cart Quantity --}}
                            <div class="flex items-center rounded-lg border border-gray-200 px-2">
                                <button type="button" wire:click="updateQty({{ $item->product->id }}, 'decrease')"
                                    class="text-gray-600 rounded-full text-center transition hover:text-white hover:bg-gray-600 disabled:opacity-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-4">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                </button>

                                <input type="number" wire:model.live.debounce.500ms="qtyInput.{{ $item->product->id }}"
                                    value="{{ $item->unit_qty }}"
                                    class="h-6 w-14 border-transparent text-center sm:text-sm appearance-none"
                                    min="1">

                                <button type="button" wire:click="updateQty({{ $item->product->id }}, 'increase')"
                                    class="text-gray-600 rounded-full text-center transition hover:text-white hover:bg-gray-600 disabled:opacity-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-4">
                                        <path stroke-linecap="round" stroke-linejoin="round"
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
</div>
