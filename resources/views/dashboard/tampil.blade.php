@extends('example.layouts.default.dashboard')
@section('content')
@section('title',"Dashboard")
@vite(['resources/css/app.css','resources/js/app.js'])
  @if (auth()->user()->role->name === 'Manager Gudang')
      <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800 mx-4 my-4">
          <div class="items-center justify-between lg:flex">
            <div class="mb-4 lg:mb-0">
              <h3 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">
                Todays Transaction
              </h3>
              <span class="text-base font-normal text-gray-500 dark:text-gray-400">

                This is a list of todays transactions
              </span>
            </div>
          </div>
      <!-- Table Manager Gudang Transaksi Hari Ini-->
        <div class="flex flex-col mt-6 mx-4">
          <div class="overflow-x-auto rounded-lg mx-4">
            <div class="inline-block min-w-full align-middle">
              <div class="overflow-hidden shadow sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                  <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                      <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                        Product Name
                      </th>
                      <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                        Category
                      </th>
                      <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                        Quantity
                      </th>
                      <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                        Current Stock
                      </th>
                      <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                        Time
                      </th>
                      <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                        Date
                      </th>
                      <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                        Status
                      </th>
                    </tr>
                  </thead>
                  <tbody class="bg-white dark:bg-gray-800">
                  @foreach($todayTransactions as $transaction)
                    <tr>
                      <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white">
                        {{$transaction->product_name}} 
                      </td>
                      <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white">
                        {{$transaction->category_name}}
                      </td>
                      <td class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                        @if($transaction->type == 'Masuk')
                          + {{$transaction->quantity}}
                        @else
                          - {{$transaction->quantity}}
                        @endif
                      </td>
                      <td class="p-4 text-sm font-semibold text-gray-900 whitespace-nowrap dark:text-white">
                        {{$transaction->stock_sementara}}</td>
                      <td class="p-4 text-sm font-normal text-left text-gray-500 dark:text-gray-400 transaction-date transaction-time">{{ \Carbon\Carbon::parse($transaction->updated_at)->setTimezone('Asia/Jakarta')->format('H:i:s') ?? 'Waktu Tidak Ditemukan' }}</td>
                      <td class="p-4 text-sm font-normal text-left text-gray-500 dark:text-gray-400 transaction-date transaction-date">{{ \Carbon\Carbon::parse($transaction->updated_at)->setTimezone('Asia/Jakarta')->format('Y-m-d') ?? 'Tanggal Tidak Ditemukan' }}</td>
                    
                      <td class="p-4 whitespace-nowrap">
                        <span
                          class="{{$transaction->status == 'Ditolak'?'bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-md border border-red-100 dark:border-red-400 dark:bg-gray-700 dark:text-red-400':
                          ($transaction->status == 'Pending'?'bg-purple-100 text-purple-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-md dark:bg-gray-700 dark:text-purple-400 border border-purple-100 dark:border-purple-500':
                          ($transaction->status == 'Dikeluarkan'?'bg-orange-100 text-orange-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-md dark:bg-gray-700 dark:text-orange-400 border border-orange-100 dark:border-orange-500':
                          'bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-md dark:bg-gray-700 dark:text-green-400 border border-green-100 dark:border-green-500')) }}">
                          {{$transaction->status}}
                        </span>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="sticky bottom-0 right-0 items-center w-full p-4 bg-white border-t border-gray-200 sm:flex sm:justify-between dark:bg-gray-800 dark:border-gray-700">
    <div class="flex items-center mb-4 sm:mb-0">
        <a href="{{ $transactions->previousPageUrl() }}" class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
            <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
        </a>
        <a href="{{ $transactions->nextPageUrl() }}" class="inline-flex justify-center p-1 mr-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
            <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
        </a>
        <span class="text-sm font-normal text-gray-500 dark:text-gray-400">Showing <span class="font-semibold text-gray-900 dark:text-white">{{ $transactions->firstItem() }}-{{ $transactions->lastItem() }}</span> of <span class="font-semibold text-gray-900 dark:text-white">{{ $transactions->total() }}</span></span>
    </div>
    <div class="flex items-center space-x-3">
        <a href="{{ $transactions->Url(1) }}" class="inline-flex items-center justify-center flex-1 px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 {{ $transactions->onFirstPage() ? 'cursor-not-allowed opacity-50' : '' }}">
            First
        </a>
        <a href="{{ $transactions->previousPageUrl() }}" class="inline-flex items-center justify-center flex-1 px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
            «
        </a>
        @php
            $start = max($transactions->currentPage() - 1, 1);
            $end = min($transactions->currentPage() + 1, $transactions->lastPage());
        @endphp
        <div class="flex items-center space-x-2">
            @if ($start > 1)
                <a href="{{ $transactions->url(1) }}" class="inline-flex items-center justify-center flex-1 px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">1</a>
                @if ($start > 2)
                    <div class="text-gray-500">...</div>
                @endif
            @endif
            @for ($i = $start; $i <= $end; $i++)
                <a href="{{ $transactions->url($i) }}" class="inline-flex items-center justify-center flex-1 px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 {{ $transactions->currentPage() == $i ? 'bg-primary-800' : '' }}">{{ $i }}</a>
            @endfor
            @if ($end < $transactions->lastPage())
                @if ($end < $transactions->lastPage() - 1)
                    <div class="text-gray-500">...</div>
                @endif
                <a href="{{ $transactions->url($transactions->lastPage()) }}" class="inline-flex items-center justify-center flex-1 px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">{{ $transactions->lastPage() }}</a>
            @endif
        </div>
        <a href="{{ $transactions->nextPageUrl() }}" class="inline-flex items-center justify-center flex-1 px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
            »
        </a>
        <a href="{{ $transactions->url($transactions->lastPage()) }}" class="inline-flex items-center justify-center flex-1 px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 {{ $transactions->currentPage() == $transactions->lastPage() ? 'cursor-not-allowed opacity-50' : '' }}">
            Last
        </a>
       </div>
        </div>
      </div>

      <!--Table Manager Gudang Transasi Hari Ini-->
  @endif

  <!-- Total User, Transaksi Masuk, dan Transaksi Keluar -->
    @if (auth()->user()->role->name == 'Admin')
      <div class="px-4 pt-9">
        <div class="grid w-full grid-cols-1 gap-4 xl:grid-cols-3 2xl:grid-cols-3">
          <div class="items-center justify-between p-6 bg-white border border-gray-200 rounded-lg shadow-sm sm:flex dark:border-gray-700 sm:p-8 dark:bg-gray-800 h-40 mx-2"> <!-- Menambahkan h-40 -->
              <div class="w-full">
                  <h3 class="text-xl font-bold leading-none text-gray-900 sm:text-xl dark:text-white">Jumlah Product</h3>
                  <span class="text-xl font-bold leading-none text-gray-900 sm:text-3xl dark:text-white">{{$prod->count()}}</span>
              </div>
              <svg class="flex-shrink-0 w-16 h-16 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16">
                  <path d="M19 0H1a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h18a1 1 0 0 0 1-1V1a1 1 0 0 0-1-1ZM2 6v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6H2Zm11 3a1 1 0 0 1-1 1H8a1 1 0 0 1-1-1V8a1 1 0 0 1 2 0h2a1 1 0 0 1 2 0v1Z"/>
              </svg>
          </div>
          <div class="items-center justify-between p-6 bg-white border border-gray-200 rounded-lg shadow-sm sm:flex dark:border-gray-700 sm:p-8 dark:bg-gray-800 h-40 mx-2"> <!-- Menambahkan h-40 -->
              <div class="w-full">
                  <h3 class="text-xl font-bold leading-none text-gray-900 sm:text-xl dark:text-white">Transaksi Masuk</h3>
                  <span class="text-xl font-bold leading-none text-gray-900 sm:text-3xl dark:text-white">{{ $transactions->where('type', 'Masuk')->count() }}</span>
              </div>
              <svg class="flex-shrink-0 w-16 h-16 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16">
                <path d="M10 16l7-7h-4V0H7v9H3z"/> 
            </svg>
          </div>
          <div class="items-center justify-between p-6 bg-white border border-gray-200 rounded-lg shadow-sm sm:flex dark:border-gray-700 sm:p-8 dark:bg-gray-800 h-40 mx-2"> <!-- Menambahkan h-40 -->
              <div class="w-full">
                  <h3 class="text-xl font-bold leading-none text-gray-900 sm:text-xl dark:text-white">Transaksi Keluar</h3>
                  <span class="text-xl font-bold leading-none text-gray-900 sm:text-3xl dark:text-white">{{ $transactions->where('type', 'Keluar')->count() }}</span>
              </div>
              <svg class="flex-shrink-0 w-16 h-16 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16">
                <path d="M10 0l-7 7h4v9h6v-9h4z"/> 
              </svg>
          </div>
      </div>
    @endif
      <!-- Total User, Transaksi Masuk, dan Transaksi Keluar -->

<!-- Grafik -->
      @if (auth()->user()->role->name == 'Admin')
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800 mt-4 mb-4">
            <div class="flex items-center justify-between mb-4">
              <div class="flex-shrink-0">
                <span class="text-xl font-bold leading-none text-gray-900 sm:text-2xl dark:text-white">Grafik</span>
                <h3 class="text-base font-light text-gray-500 dark:text-gray-400">Stock Product</h3>
              </div>
              <div class="flex items-center justify-end flex-1 text-base font-medium text-green-500 dark:text-green-400">
                <select id="year-filter" class="ml-2 bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                  @for ($year = date('Y'); $year >= 2020; $year--) <!-- Menambahkan dropdown tahun -->
                      <option value="{{ $year }}">{{ $year }}</option>
                  @endfor
                </select>
              </div>
            </div>
            <canvas id="main-chart" width="200px" height="75px"></canvas>
            <!-- Card Footer -->
          </div>
        </div>
      @endif
<!-- Grafik -->

      <div class="p-4 bg-white  border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800 mx-4 mt-6">
        <div class="items-center justify-between lg:flex">
          <div class="mb-4 lg:mb-0">
            <h3 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">
              @if (auth()->user()->role->name === 'Admin')
              Transaction
              @endif
              @if (auth()->user()->role->name === 'Manager Gudang')
              Stock Menipis dan Habis
              @endif
              @if (auth()->user()->role->name === 'Staff Gudang')
              Pending Transaction
              @endif
            </h3>
            <span class="text-base font-normal text-gray-500 dark:text-gray-400">
              @if (auth()->user()->role->name === 'Admin')
              This is a list of latest transactions
              @endif
              @if (auth()->user()->role->name === 'Manager Gudang')
              This is a list of stock menipis and habis
              @endif
              @if (auth()->user()->role->name === 'Staff Gudang')
              This is a list of pending transactions
              @endif
            </span>
        </div>
      <div class="items-center sm:flex">

<!-- Filter Tanggal -->
@if (auth()->user()->role->name === 'Admin')
  <form method="GET" action="{{ route('dashboard.tampil') }}">
            <div class="flex items-center space-x-4">
              <div class="col-span-6 sm:col-span-3 flex items-center mr-3">
                <label for="start-date" class="block text-sm font-medium text-gray-900 dark:text-white mr-1">Start Date</label>
                <input type="date" name="start-date" id="start-date" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
              </div>

              <div class="col-span-6 sm:col-span-3 flex items-center mr-3">
                  <label for="end-date" class="block text-sm font-medium text-gray-900 dark:text-white mr-1">End Date</label>
                  <input type="date" name="end-date" id="end-date" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
              </div>
              <button type="submit" class="inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 sm:w-auto dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                </svg>
                Filter
              </button>
            </div>
          </form>
@endif
</div>
</div>
<!-- Filter Tanggal -->
      

      <!-- Table Admin -->
  @if (auth()->user()->role->name === 'Admin')
      <div class="flex flex-col mt-6 mx-4">
        <div class="overflow-x-auto rounded-lg mx-4">
          <div class="inline-block min-w-full align-middle">
            <div class="overflow-hidden shadow sm:rounded-lg">
              <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                <thead class="bg-gray-50 dark:bg-gray-700">
                  <tr>
                    <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                      Product Name
                    </th>
                    <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                       Category
                    </th>
                    <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                      Quantity
                    </th>
                    <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                      Current Stock
                    </th>
                    <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                      Time
                    </th>
                    <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                      Date
                    </th>
                    <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                      Status
                    </th>
                  </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800">
                @foreach($transactions->whereIn('status', ['Diterima', 'Dikeluarkan']) as $transaction)
                  <tr>
                    <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white">
                      {{$transaction->product_name}} 
                    </td>
                    <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white">
                      {{$transaction->category_name}}
                    </td>
                    <td class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                      @if($transaction->type == 'Masuk')
                        + {{$transaction->quantity}}
                      @else
                        - {{$transaction->quantity}}
                      @endif
                    </td>
                    <td class="p-4 text-sm font-semibold text-gray-900 whitespace-nowrap dark:text-white">
                      {{$transaction->stock_sementara}}</td>
                    <td class="p-4 text-sm font-normal text-left text-gray-500 dark:text-gray-400 transaction-date transaction-time">{{ \Carbon\Carbon::parse($transaction->updated_at)->setTimezone('Asia/Jakarta')->format('H:i:s') ?? 'Waktu Tidak Ditemukan' }}</td>
                    <td class="p-4 text-sm font-normal text-left text-gray-500 dark:text-gray-400 transaction-date transaction-date">{{ \Carbon\Carbon::parse($transaction->updated_at)->setTimezone('Asia/Jakarta')->format('Y-m-d') ?? 'Tanggal Tidak Ditemukan' }}</td>
                   
                    <td class="p-4 whitespace-nowrap">
                      <span
                        class="{{$transaction->status == 'Ditolak'?'bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-md border border-red-100 dark:border-red-400 dark:bg-gray-700 dark:text-red-400':
                        ($transaction->status == 'Pending'?'bg-purple-100 text-purple-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-md dark:bg-gray-700 dark:text-purple-400 border border-purple-100 dark:border-purple-500':
                        ($transaction->status == 'Dikeluarkan'?'bg-orange-100 text-orange-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-md dark:bg-gray-700 dark:text-orange-400 border border-orange-100 dark:border-orange-500':
                        'bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-md dark:bg-gray-700 dark:text-green-400 border border-green-100 dark:border-green-500')) }}">
                        {{$transaction->status}}
                      </span>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="sticky bottom-0 right-0 items-center w-full p-4 bg-white border-t border-gray-200 sm:flex sm:justify-between dark:bg-gray-800 dark:border-gray-700">
    <div class="flex items-center mb-4 sm:mb-0">
        <a href="{{ $transactions->previousPageUrl() }}" class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
            <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
        </a>
        <a href="{{ $transactions->nextPageUrl() }}" class="inline-flex justify-center p-1 mr-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
            <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
        </a>
        <span class="text-sm font-normal text-gray-500 dark:text-gray-400">Showing <span class="font-semibold text-gray-900 dark:text-white">{{ $transactions->firstItem() }}-{{ $transactions->lastItem() }}</span> of <span class="font-semibold text-gray-900 dark:text-white">{{ $transactions->total() }}</span></span>
    </div>
    <div class="flex items-center space-x-3">
        <a href="{{ $transactions->Url(1) }}" class="inline-flex items-center justify-center flex-1 px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 {{ $transactions->onFirstPage() ? 'cursor-not-allowed opacity-50' : '' }}">
            First
        </a>
        <a href="{{ $transactions->previousPageUrl() }}" class="inline-flex items-center justify-center flex-1 px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
            «
        </a>
        @php
            $start = max($transactions->currentPage() - 1, 1);
            $end = min($transactions->currentPage() + 1, $transactions->lastPage());
        @endphp
        <div class="flex items-center space-x-2">
            @if ($start > 1)
                <a href="{{ $transactions->url(1) }}" class="inline-flex items-center justify-center flex-1 px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">1</a>
                @if ($start > 2)
                    <div class="text-gray-500">...</div>
                @endif
            @endif
            @for ($i = $start; $i <= $end; $i++)
                <a href="{{ $transactions->url($i) }}" class="inline-flex items-center justify-center flex-1 px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 {{ $transactions->currentPage() == $i ? 'bg-primary-800' : '' }}">{{ $i }}</a>
            @endfor
            @if ($end < $transactions->lastPage())
                @if ($end < $transactions->lastPage() - 1)
                    <div class="text-gray-500">...</div>
                @endif
                <a href="{{ $transactions->url($transactions->lastPage()) }}" class="inline-flex items-center justify-center flex-1 px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">{{ $transactions->lastPage() }}</a>
            @endif
        </div>
        <a href="{{ $transactions->nextPageUrl() }}" class="inline-flex items-center justify-center flex-1 px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
            »
        </a>
        <a href="{{ $transactions->url($transactions->lastPage()) }}" class="inline-flex items-center justify-center flex-1 px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 {{ $transactions->currentPage() == $transactions->lastPage() ? 'cursor-not-allowed opacity-50' : '' }}">
            Last
        </a>
       </div>
        </div>
  @endif
       <!-- Table Admin -->
      
      <!-- Table Manager Stock Menipis-->
     @if (auth()->user()->role->name === 'Manager Gudang')
            <div class="flex flex-col mt-6 mx-4">
              <div class="overflow-x-auto rounded-lg mx-4">
                <div class="inline-block min-w-full align-middle">
                  <div class="overflow-hidden shadow sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                      <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>

                        <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                            Image
                          </th>
                          <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                            SKU
                          </th>
                          <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                            Product Name
                          </th>
                          <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                            Category
                          </th>
                          <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                            Current Stock
                          </th>
                          <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                            Status
                          </th>
                        </tr>
                      </thead>
                  <tbody class="bg-white dark:bg-gray-800">
                  @foreach($stockOpname as $opname)
                  @if($opname['stock_akhir'] < $opname->product->stock_min) <!-- Stock Minimum -->
                  <tr>
                    <td class="p-4 text-sm font-semibold text-gray-900 whitespace-nowrap dark:text-white">
                      @if($opname->product->image)
                          <img src="{{ asset('storage/' . $opname->product->image) }}" alt="{{ $opname->product->name }}" class="w-16 h-16 object-cover rounded-lg">
                      @else
                          <span>No Image</span>
                      @endif
                    </td>
                    <td class="p-4 text-sm font-semibold text-gray-900 whitespace-nowrap dark:text-white">
                      {{ $opname->product->sku }}
                    </td>
                    <td class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                      {{ $opname->category->name }}
                    </td>
                    <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white">
                      {{ $opname->product->name }}
                    </td>
                    <td class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                      {{ $opname['stock_akhir']}}
                    </td>
                    
                    <td class="p-4 whitespace-nowrap">
                      @if($opname['stock_akhir'] === 0)
                        <span class="bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-md border border-red-100 dark:bg-gray-700 dark:border-red-500 dark:text-red-400">Stock Habis</span>
                      @elseif($opname['stock_akhir'] < $opname->product->stock_min)
                        <span class="bg-orange-100 text-orange-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-md border border-orange-100 dark:bg-gray-700 dark:border-orange-300 dark:text-orange-300">Stock Menipis</span>
                      @else
                        <span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-md border border-green-100 dark:bg-gray-700 dark:border-green-500 dark:text-green-400">Stock Aman</span>
                      @endif
                    </td>
                  </tr>
                  @endif
                  @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="sticky bottom-0 right-0 items-center w-full p-4 bg-white border-t border-gray-200 sm:flex sm:justify-between dark:bg-gray-800 dark:border-gray-700">
        <div class="flex items-center mb-4 sm:mb-0">
            <a href="{{ $stockOpname->previousPageUrl() }}" class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
            </a>
            <a href="{{ $stockOpname->nextPageUrl() }}" class="inline-flex justify-center p-1 mr-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
            </a>
            <span class="text-sm font-normal text-gray-500 dark:text-gray-400">Showing <span class="font-semibold text-gray-900 dark:text-white">{{ $stockOpname->firstItem() }}-{{ $stockOpname->lastItem() }}</span> of <span class="font-semibold text-gray-900 dark:text-white">{{ $stockOpname->total() }}</span></span>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ $stockOpname->Url(1) }}" class="inline-flex items-center justify-center flex-1 px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 {{ $stockOpname->onFirstPage() ? 'cursor-not-allowed opacity-50' : '' }}">
                First
            </a>
            <a href="{{ $stockOpname->previousPageUrl() }}" class="inline-flex items-center justify-center flex-1 px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                «
            </a>
            @php
                $start = max($stockOpname->currentPage() - 1, 1);
                $end = min($stockOpname->currentPage() + 1, $stockOpname->lastPage());
            @endphp
            <div class="flex items-center space-x-2">
                @if ($start > 1)
                    <a href="{{ $stockOpname->url(1) }}" class="inline-flex items-center justify-center flex-1 px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">1</a>
                    @if ($start > 2)
                        <div class="text-gray-500">...</div>
                    @endif
                @endif
                @for ($i = $start; $i <= $end; $i++)
                    <a href="{{ $stockOpname->url($i) }}" class="inline-flex items-center justify-center flex-1 px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 {{ $stockOpname->currentPage() == $i ? 'bg-primary-800' : '' }}">{{ $i }}</a>
                @endfor
                @if ($end < $stockOpname->lastPage())
                    @if ($end < $stockOpname->lastPage() - 1)
                        <div class="text-gray-500">...</div>
                    @endif
                    <a href="{{ $stockOpname->url($stockOpname->lastPage()) }}" class="inline-flex items-center justify-center flex-1 px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">{{ $stockOpname->lastPage() }}</a>
                @endif
            </div>
            <a href="{{ $stockOpname->nextPageUrl() }}" class="inline-flex items-center justify-center flex-1 px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                »
            </a>
            <a href="{{ $stockOpname->url($stockOpname->lastPage()) }}" class="inline-flex items-center justify-center flex-1 px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 {{ $stockOpname->currentPage() == $stockOpname->lastPage() ? 'cursor-not-allowed opacity-50' : '' }}">
                Last
            </a>
        </div>
      </div>
     @endif
      <!-- Table Manager Stock Menipis-->

      <!-- Tabel Staff Gudang Pending Transaksi-->
  @if (auth()->user()->role->name === 'Staff Gudang')
      <div class="flex flex-col mt-6 mx-4">
        <div class="overflow-x-auto rounded-lg mx-4">
          <div class="inline-block min-w-full align-middle">
            <div class="overflow-hidden shadow sm:rounded-lg">
              <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                <thead class="bg-gray-50 dark:bg-gray-700">
                  <tr>
                    <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                      Product Name
                    </th>
                    <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                       Category
                    </th>
                    <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                      Quantity
                    </th>
                    <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                      Current Stock
                    </th>
                    <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                      Time
                    </th>
                    <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                      Date
                    </th>
                    <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                      Status
                    </th>
                  </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800">
                @foreach($allTransactions->where('status', 'Pending') as $transaction)
                  <tr>
                    <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white">
                      {{$transaction->product_name}} 
                    </td>
                    <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white">
                      {{$transaction->category_name}}
                    </td>
                    <td class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                      @if($transaction->type == 'Masuk')
                        + {{$transaction->quantity}}
                      @else
                        - {{$transaction->quantity}}
                      @endif
                    </td>
                    <td class="p-4 text-sm font-semibold text-gray-900 whitespace-nowrap dark:text-white">
                      {{$transaction->stock_sementara}}</td>
                    <td class="p-4 text-sm font-normal text-left text-gray-500 dark:text-gray-400 transaction-date transaction-time">{{ \Carbon\Carbon::parse($transaction->updated_at)->setTimezone('Asia/Jakarta')->format('H:i:s') ?? 'Waktu Tidak Ditemukan' }}</td>
                    <td class="p-4 text-sm font-normal text-left text-gray-500 dark:text-gray-400 transaction-date transaction-date">{{ \Carbon\Carbon::parse($transaction->updated_at)->setTimezone('Asia/Jakarta')->format('Y-m-d') ?? 'Tanggal Tidak Ditemukan' }}</td>
                    <td class="p-4 whitespace-nowrap">
                      <span class="bg-purple-100 text-purple-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-md dark:bg-gray-700 dark:text-purple-400 border border-purple-100 dark:border-purple-500">
                        {{$transaction->status}}
                      </span>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <!-- Pagination -->
      <div class="sticky bottom-0 right-0 items-center w-full p-4 bg-white border-t border-gray-200 sm:flex sm:justify-between dark:bg-gray-800 dark:border-gray-700">
      <div class="flex items-center mb-4 sm:mb-0">
        <a href="{{ $transactions->previousPageUrl() }}" class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
            <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
        </a>
        <a href="{{ $transactions->nextPageUrl() }}" class="inline-flex justify-center p-1 mr-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
            <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
        </a>
        <span class="text-sm font-normal text-gray-500 dark:text-gray-400">Showing <span class="font-semibold text-gray-900 dark:text-white">{{ $transactions->firstItem() }}-{{ $transactions->lastItem() }}</span> of <span class="font-semibold text-gray-900 dark:text-white">{{ $transactions->total() }}</span></span>
    </div>
    <div class="flex items-center space-x-3">
        <a href="{{ $transactions->Url(1) }}" class="inline-flex items-center justify-center flex-1 px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 {{ $transactions->onFirstPage() ? 'cursor-not-allowed opacity-50' : '' }}">
            First
        </a>
        <a href="{{ $transactions->previousPageUrl() }}" class="inline-flex items-center justify-center flex-1 px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
            «
        </a>
        @php
            $start = max($transactions->currentPage() - 1, 1);
            $end = min($transactions->currentPage() + 1, $transactions->lastPage());
        @endphp
        <div class="flex items-center space-x-2">
            @if ($start > 1)
                <a href="{{ $transactions->url(1) }}" class="inline-flex items-center justify-center flex-1 px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">1</a>
                @if ($start > 2)
                    <div class="text-gray-500">...</div>
                @endif
            @endif
            @for ($i = $start; $i <= $end; $i++)
                <a href="{{ $transactions->url($i) }}" class="inline-flex items-center justify-center flex-1 px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 {{ $transactions->currentPage() == $i ? 'bg-primary-800' : '' }}">{{ $i }}</a>
            @endfor
            @if ($end < $transactions->lastPage())
                @if ($end < $transactions->lastPage() - 1)
                    <div class="text-gray-500">...</div>
                @endif
                <a href="{{ $transactions->url($transactions->lastPage()) }}" class="inline-flex items-center justify-center flex-1 px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">{{ $transactions->lastPage() }}</a>
            @endif
        </div>
        <a href="{{ $transactions->nextPageUrl() }}" class="inline-flex items-center justify-center flex-1 px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
            »
        </a>
        <a href="{{ $transactions->url($transactions->lastPage()) }}" class="inline-flex items-center justify-center flex-1 px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 {{ $transactions->currentPage() == $transactions->lastPage() ? 'cursor-not-allowed opacity-50' : '' }}">
            Last
        </a>
       </div>
        </div>
    @endif
      <!-- Tabel Staff Gudang Pending Transaksi-->  

<!-- Pagination -->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const transaction = @json($allTransactions); // Menggunakan $allTransactions sebagai sumber data
  const stockPerMonth = Array.from({ length: 12 }, () => 0);

  transaction.forEach(transaction => {
    const month = new Date(transaction.updated_at).getMonth();
    if (transaction.type === 'Masuk' && transaction.status === 'Diterima') {
      stockPerMonth[month] += transaction.quantity;
    } else if (transaction.type === 'Keluar' && transaction.status === 'Dikeluarkan') {
      stockPerMonth[month] -= transaction.quantity;
    }
  });

  const ctx = document.getElementById('main-chart').getContext('2d');
  const myChart = new Chart(ctx, {
      type: 'line',
      data: {
          labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
          datasets: [{
              label: 'Jumlah Stock',
              data: stockPerMonth,
              backgroundColor: 'rgba(26,86,219,0.2)', // Ubah warna latar belakang di sini
              borderColor: 'rgba(26,86,219,1)',
              borderWidth: 1
          }]
      },
      options: {
          scales: {
              y: {
                  beginAtZero: true
              }
          }
      }
  });

  function toggleDropdown() {
    const dropdown = document.getElementById('dropdown');
    dropdown.classList.toggle('hidden');
}

function filterTransactions() {
    const checkboxes = document.querySelectorAll('.filter-checkbox');
    const selectedStatuses = Array.from(checkboxes)
        .filter(checkbox => checkbox.checked)
        .map(checkbox => checkbox.value);

    console.log('Selected Statuses:', selectedStatuses); // Debugging

    const rows = document.querySelectorAll('tbody tr');
    rows.forEach(row => {
        const status = row.querySelector('td:last-child span').textContent.trim(); // Mengambil status dari kolom terakhir
        console.log('Row Status:', status); // Debugging
        if (selectedStatuses.length === 0 || selectedStatuses.includes(status)) {
            row.style.display = ''; // Tampilkan baris
        } else {
            row.style.display = 'none'; // Sembunyikan baris
        }
    });
  }


</script>
@endsection
