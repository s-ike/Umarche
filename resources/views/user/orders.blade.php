<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            購入履歴
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if (count($orders) > 0)
                        @foreach ($orders as $order)
                            <div class="flex">
                                <div>
                                    注文日: {{ $order->created_at->format('Y年m月d日') }}
                                </div>
                                <div class="ml-4">
                                    合計: {{ $order->total_price }}円
                                </div>
                            </div>
                            @if ($order->products)
                                <div class="ml-12">
                                @foreach ($order->products as $product)
                                    <div class="flex">
                                        <div>
                                            {{ $product->product_name }}
                                        </div>
                                        <div class="ml-4">
                                            {{ number_format($product->price) }}円
                                        </div>
                                        <div class="ml-4">
                                            {{ $product->quantity }}個
                                        </div>
                                        <div class="ml-4">
                                            計: {{ number_format($product->price * $product->quantity) }}円
                                        </div>
                                    </div>
                                @endforeach
                                </div>
                            @endif
                        @endforeach
                    @else
                        購入履歴はありません。
                    @endif
                </div>
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
