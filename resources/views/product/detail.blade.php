<!-- Main modal -->
<div id="detail-product-modal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                <div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white" id="detail-product-name">{{$product->name}}</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-300" id="detail-product-sku"></p>
                </div>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="product-detail-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-6 space-y-6">
            <div class="flex justify-center mb-4">
                    <img id="detail-product-image" class="max-w-full h-auto rounded-lg" style="max-height: 300px;"
                     alt="Product Image" src="{{ asset('storage/' . $product->image) }}">

                </div>

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
                <div>
                    <dt class="font-semibold text-gray-900 dark:text-white">Deskripsi</dt>
                    <dd class="mt-1 text-gray-600 dark:text-gray-300" id="detail-product-description">{{ $product->description }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-gray-900 dark:text-white">Stock Awal</dt>
                    <dd class="mt-1 text-gray-600 dark:text-gray-300" id="detail-product-stock">{{ $product->stock }}</dd>
                </div>
            </div>
        </div>
    </div>
</div>