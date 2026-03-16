<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-800 leading-tight uppercase tracking-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                <div class="bg-white p-8 rounded-[2rem] shadow-xl border border-gray-100 group hover:bg-gray-900 transition-all duration-500">
                    <span class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2 group-hover:text-gray-500">Total Sales</span>
                    <span class="text-4xl font-black text-gray-900 group-hover:text-white transition-colors">${{ number_format($stats['total_sales'], 2) }}</span>
                </div>
                <div class="bg-white p-8 rounded-[2rem] shadow-xl border border-gray-100 group hover:bg-indigo-600 transition-all duration-500">
                    <span class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2 group-hover:text-indigo-200">Total Orders</span>
                    <span class="text-4xl font-black text-gray-900 group-hover:text-white transition-colors">{{ $stats['total_orders'] }}</span>
                </div>
                <div class="bg-white p-8 rounded-[2rem] shadow-xl border border-gray-100 group hover:bg-red-500 transition-all duration-500">
                    <span class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2 group-hover:text-red-200">Products</span>
                    <span class="text-4xl font-black text-gray-900 group-hover:text-white transition-colors">{{ $stats['total_products'] }}</span>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-[2.5rem] border border-gray-100">
                <div class="p-8 md:p-12">
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="text-2xl font-black text-gray-900 uppercase tracking-tight">Recent Activity</h3>
                        <a href="#" class="text-xs font-black text-indigo-600 uppercase tracking-widest hover:underline">View All Orders</a>
                    </div>

                    <div class="overflow-x-auto rounded-3xl border border-gray-50">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 uppercase text-[10px] font-black text-gray-400 tracking-[0.2em]">
                                    <th class="px-8 py-5">Order #</th>
                                    <th class="px-8 py-5">Customer</th>
                                    <th class="px-8 py-5">Status</th>
                                    <th class="px-8 py-5">Amount</th>
                                    <th class="px-8 py-5 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50 text-sm font-bold text-gray-700">
                                @foreach($stats['recent_orders'] as $order)
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <td class="px-8 py-6 font-black text-gray-900">{{ $order->order_number }}</td>
                                        <td class="px-8 py-6">{{ $order->user->name }}</td>
                                        <td class="px-8 py-6">
                                            <span class="px-3 py-1 rounded-full text-[10px] uppercase font-black tracking-widest
                                                {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-600' : '' }}
                                                {{ $order->status === 'processing' ? 'bg-blue-100 text-blue-600' : '' }}
                                                {{ $order->status === 'shipped' ? 'bg-indigo-100 text-indigo-600' : '' }}
                                                {{ $order->status === 'delivered' ? 'bg-green-100 text-green-600' : '' }}
                                            ">
                                                {{ $order->status }}
                                            </span>
                                        </td>
                                        <td class="px-8 py-6">${{ number_format($order->total_amount, 2) }}</td>
                                        <td class="px-8 py-6 text-right">
                                            <button class="px-4 py-2 bg-gray-100 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-gray-200 transition-colors">Manage</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
