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


           {{-- =========================== Content End Here ============================ --}}
       </div>


   </div>


   {{-- =========================== Page Layout End Here ============================ --}}
