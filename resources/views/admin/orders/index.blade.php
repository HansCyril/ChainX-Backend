<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-black text-2xl text-gray-800 leading-tight uppercase tracking-tight">Order Management</h2>
            <span class="text-sm font-bold text-gray-500">{{ $orders->total() }} total orders</span>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-700 font-bold px-6 py-4 rounded-2xl">{{ session('success') }}</div>
            @endif

            <!-- Filters -->
            <div class="bg-white rounded-[2rem] shadow-xl border border-gray-100 p-6 mb-6">
                <form method="GET" class="flex flex-wrap gap-4 items-end">
                    <div class="flex-1 min-w-[200px]">
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Search</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Order # or customer..." class="w-full rounded-xl border-gray-200 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div class="min-w-[160px]">
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Status</label>
                        <select name="status" class="w-full rounded-xl border-gray-200 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">All Statuses</option>
                            @foreach(['pending','processing','shipped','delivered','cancelled'] as $s)
                                <option value="{{ $s }}" @selected(request('status') === $s)>{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="px-6 py-2.5 bg-gray-900 text-white rounded-xl text-sm font-black uppercase tracking-widest hover:bg-indigo-600 transition-colors">Filter</button>
                        <a href="{{ route('admin.orders.index') }}" class="px-6 py-2.5 bg-gray-100 text-gray-600 rounded-xl text-sm font-black uppercase tracking-widest hover:bg-gray-200 transition-colors">Reset</a>
                    </div>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-[2.5rem] border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100 uppercase text-[10px] font-black text-gray-400 tracking-[0.2em]">
                                <th class="px-8 py-5">Order #</th>
                                <th class="px-8 py-5">Customer</th>
                                <th class="px-8 py-5">Status</th>
                                <th class="px-8 py-5">Payment</th>
                                <th class="px-8 py-5">Rider</th>
                                <th class="px-8 py-5">Date</th>
                                <th class="px-8 py-5 text-right">Total</th>
                                <th class="px-8 py-5 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 text-sm font-bold text-gray-700">
                            @forelse($orders as $order)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-8 py-5 font-black text-gray-900">{{ $order->order_number }}</td>
                                    <td class="px-8 py-5">
                                        <div class="font-bold text-gray-900">{{ $order->user->name }}</div>
                                        <div class="text-xs text-gray-400 font-medium">{{ $order->user->email }}</div>
                                    </td>
                                    <td class="px-8 py-5">
                                        @php
                                            $colors = ['pending'=>'yellow','processing'=>'blue','shipped'=>'indigo','delivered'=>'green','cancelled'=>'red'];
                                            $c = $colors[$order->status] ?? 'gray';
                                        @endphp
                                        <span class="px-3 py-1 rounded-full text-[10px] uppercase font-black tracking-widest bg-{{ $c }}-100 text-{{ $c }}-600">{{ $order->status }}</span>
                                    </td>
                                    <td class="px-8 py-5">
                                        @php $pc = ['pending'=>'yellow','paid'=>'green','failed'=>'red','refunded'=>'purple'][$order->payment_status] ?? 'gray'; @endphp
                                        <span class="px-3 py-1 rounded-full text-[10px] uppercase font-black tracking-widest bg-{{ $pc }}-100 text-{{ $pc }}-600">{{ $order->payment_status }}</span>
                                    </td>
                                    <td class="px-8 py-5">
                                        @if($order->rider)
                                            <div class="font-black text-gray-900">{{ $order->rider->name }}</div>
                                            <div class="text-[9px] text-gray-400 uppercase tracking-widest">{{ $order->rider->vehicle }}</div>
                                        @else
                                            <span class="text-[10px] font-bold text-gray-300 italic uppercase">Not Assigned</span>
                                        @endif
                                    </td>
                                    <td class="px-8 py-5 text-gray-400">{{ $order->created_at->format('M d, Y') }}</td>
                                    <td class="px-8 py-5 text-right font-black text-gray-900">₱{{ number_format($order->total_amount, 2) }}</td>
                                    <td class="px-8 py-5 text-right">
                                        <a href="{{ route('admin.orders.show', $order) }}" class="px-4 py-2 bg-indigo-50 text-indigo-600 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-indigo-100 transition-colors">Manage</a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="7" class="px-8 py-16 text-center text-gray-400 font-bold">No orders found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-8 py-6 border-t border-gray-50">{{ $orders->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
