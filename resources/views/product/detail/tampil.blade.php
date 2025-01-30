@extends('example.layouts.default.dashboard')
@section('content')
@section('title',"Detail Product")


<div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
    <div class="w-full mb-1">
        <div class="mb-4">
            <nav class="flex mb-5" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 text-sm font-medium md:space-x-2">
                  <li class="inline-flex items-center">
                    <a href="#" class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-white">
                      <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                      Home
                    </a>
                  </li>
                  <li>
                    <div class="flex items-center">
                      <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                      <a href="#" class="ml-1 text-gray-700 hover:text-primary-600 md:ml-2 dark:text-gray-300 dark:hover:text-white">Products</a>
                    </div>
                  </li>
                  <li>
                    <div class="flex items-center">
                      <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                      <span class="ml-1 text-gray-400 md:ml-2 dark:text-gray-500" aria-current="page">Detail</span>
                    </div>
                  </li>
                </ol>
            </nav>
            <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Detail Product</h1>
        </div>
        <div class="sm:flex">
           
            @if (Auth::user()->role == 'Admin')
            <div class="flex items-center ml-auto space-x-2 sm:space-x-3">
                <button type="button" data-modal-target="detail-product-modal" data-modal-toggle="detail-product-modal" class="inline-flex items-center justify-center w-1/2 px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 sm:w-auto dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                    <svg class="w-5 h-5 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                    Tambah
                </button>
            </div>
            @endif
        </div>
    </div>
</div>
<div class="flex flex-col h-screen">
    <div class="overflow-x-auto flex-grow">
        <div class="inline-block min-w-full align-middle">
            <div class="overflow-hidden shadow">
                <div class="w-full h-full p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700">
                <div class="p-6 space-y-6">
            <h3 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">{{$product->name}}</h3>   
            <div class="flex mb-4 grid-cols-2">
                    <img id="detail-product-image" class="max- rounded-lg mr-2" style="max-height: 150px;"
                     alt="Product Image" src="{{ asset('storage/' . $product->image) }}">
                     <div>
                    <dt class="font-semibold text-gray-900 dark:text-white">Deskripsi</dt>
                    <dd class="mt-1 text-gray-600 dark:text-gray-300" id="detail-product-description">{{ $product->description }}</dd>
                </div>
                </div>
                <div class="grid grid-cols-3 md:grid-cols-3 gap-4">  
                <div>
                    <dt class="font-semibold text-gray-900 dark:text-white">SKU</dt>
                    <dd class="mt-1 text-gray-600 dark:text-gray-300" id="detail-product-sku">{{ $product->sku }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-gray-900 dark:text-white">Supplier</dt>
                    <dd class="mt-1 text-gray-600 dark:text-gray-300" id="detail-product-supplier">{{ $product->supplier->name }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-gray-900 dark:text-white">Kategori</dt>
                    <dd class="mt-1 text-gray-600 dark:text-gray-300" id="detail-product-category">{{ $product->category->name }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-gray-900 dark:text-white">Harga Beli</dt>
                    <dd class="mt-1 text-gray-600 dark:text-gray-300" id="detail-product-purchase-price">{{ $product->purchase_price }}</dd>
                </div>
                
                <div>
                    <dt class="font-semibold text-gray-900 dark:text-white">Harga Jual</dt>
                    <dd class="mt-1 text-gray-600 dark:text-gray-300" id="detail-product-selling-price">{{ $product->selling_price }}</dd>
                </div>
                <div class="flex space-x-4">
                    <div>
                        <dt class="font-semibold text-gray-900 dark:text-white">Stock Awal</dt>
                        <dd class="mt-1 text-gray-600 dark:text-gray-300" id="detail-product-stock">{{ $product->stock }}</dd>
                    </div>
                    <div>
                        <dt class="font-semibold text-gray-900 dark:text-white">Stock Minimal</dt>
                        <dd class="mt-1 text-gray-600 dark:text-gray-300" id="detail-product-stock-min">{{ $product->stock_min }}</dd>
                    </div>
                </div>
                    <div>
                        <dt class="font-semibold text-gray-900 dark:text-white">Atribute</dt>
                    </div>
                    <div>
                        <dt class="font-semibold text-gray-900 dark:text-white">Value</dt>
                    </div>
                <div>
                    </div>

                    @foreach($atribute as $atribute)
                    <div>
                        <dd class="mt-1 text-gray-600 dark:text-gray-300" id="detail-product-stock">{{$atribute->name}}</dd>
                    </div>
                    <div>
                        <dd class="mt-1 text-gray-600 dark:text-gray-300" id="detail-product-stock">{{$atribute->value}}</dd>
                    </div>
                    <div>
                        </div>
                        @endforeach
                </div>

            </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="sticky bottom-0 right-0 items-center w-full p-4 bg-white border-t border-gray-200 sm:flex sm:justify-between dark:bg-gray-800 dark:border-gray-700">
    <div class="flex items-center mb-4 sm:mb-0">
        <a href="#" class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
            <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
        </a>
        <a href="#" class="inline-flex justify-center p-1 mr-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
            <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
        </a>
        <span class="text-sm font-normal text-gray-500 dark:text-gray-400">Showing <span class="font-semibold text-gray-900 dark:text-white">1-20</span> of <span class="font-semibold text-gray-900 dark:text-white">2290</span></span>
    </div>
    <div class="flex items-center space-x-3">
        <a href="#" class="inline-flex items-center justify-center flex-1 px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
            <svg class="w-5 h-5 mr-1 -ml-1"" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
            Previous
        </a>
        <a href="#" class="inline-flex items-center justify-center flex-1 px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
            Next
            <svg class="w-5 h-5 ml-1 -mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
        </a>
    </div>
</div>



@include('product.detail.tambah')

@endsection
