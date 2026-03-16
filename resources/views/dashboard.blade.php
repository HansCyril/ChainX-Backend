<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-black mb-8 uppercase tracking-tight">Recent Orders</h3>
                    
                    @php
                        $orders = auth()->user()->orders()->latest()->get();
                    @endphp

                    @if($orders->count() > 0)
                        <div class="overflow-x-auto rounded-[1.5rem] border border-gray-100">
                            <table class="w-full text-left border-collapse">
                                <thead class="bg-gray-50 uppercase text-[10px] font-black text-gray-400 tracking-[0.2em]">
                                    <tr>
                                        <th class="px-6 py-4">Order #</th>
                                        <th class="px-6 py-4">Status</th>
                                        <th class="px-6 py-4">Date</th>
                                        <th class="px-6 py-4 text-right">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50 text-sm font-bold text-gray-700">
                                    @foreach($orders as $order)
                                        <tr class="hover:bg-gray-50/50 transition-colors">
                                            <td class="px-6 py-4 font-black">{{ $order->order_number }}</td>
                                            <td class="px-6 py-4">
                                                <span class="px-3 py-1 rounded-full text-[10px] uppercase font-black tracking-widest
                                                    {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-600' : '' }}
                                                    {{ $order->status === 'processing' ? 'bg-blue-100 text-blue-600' : '' }}
                                                    {{ $order->status === 'shipped' ? 'bg-indigo-100 text-indigo-600' : '' }}
                                                    {{ $order->status === 'delivered' ? 'bg-green-100 text-green-600' : '' }}
                                                    {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-600' : '' }}
                                                ">
                                                    {{ $order->status }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-gray-400">{{ $order->created_at->format('M d, Y') }}</td>
                                            <td class="px-6 py-4 text-right font-black text-gray-900">${{ number_format($order->total_amount, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-12 bg-gray-50 rounded-[1.5rem] border-2 border-dashed border-gray-100">
                            <p class="text-gray-400 font-bold italic">No orders found yet.</p>
                            <a href="{{ route('products.index') }}" class="mt-4 inline-block text-indigo-600 font-black uppercase text-xs tracking-widest hover:underline">Start Shopping</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
