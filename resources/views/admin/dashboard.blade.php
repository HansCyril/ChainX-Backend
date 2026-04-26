<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-800 leading-tight uppercase tracking-tight">Admin Dashboard</h2>
    </x-slot>

    <div class="py-12 bg-gray-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-700 font-bold px-6 py-4 rounded-2xl">{{ session('success') }}</div>
            @endif

            <!-- Stats -->
            <div class="grid grid-cols-2 md:grid-cols-5 gap-6 mb-8">
                <div class="block bg-white p-8 rounded-[2rem] shadow-xl border border-gray-100 group hover:bg-gray-900 transition-all duration-500">
                    <span class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2 group-hover:text-gray-500">Total Sales</span>
                    <span class="text-4xl font-black text-gray-900 group-hover:text-white transition-colors">₱{{ number_format($stats['total_sales'], 2) }}</span>
                </div>
                <div class="block bg-white p-8 rounded-[2rem] shadow-xl border border-gray-100 group hover:bg-indigo-600 transition-all duration-500">
                    <span class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2 group-hover:text-indigo-200">Total Orders</span>
                    <span class="text-4xl font-black text-gray-900 group-hover:text-white transition-colors">{{ $stats['total_orders'] }}</span>
                </div>
                <a href="{{ route('admin.products.index') }}" class="block bg-white p-8 rounded-[2rem] shadow-xl border border-gray-100 group hover:bg-red-500 transition-all duration-500">
                    <span class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2 group-hover:text-red-200 flex justify-between">
                        Products
                        <svg class="w-4 h-4 text-slate-300 group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </span>
                    <span class="text-4xl font-black text-gray-900 group-hover:text-white transition-colors">{{ $stats['total_products'] }}</span>
                </a>
                <a href="{{ route('admin.categories.index') }}" class="block bg-white p-8 rounded-[2rem] shadow-xl border border-gray-100 group hover:bg-orange-500 transition-all duration-500">
                    <span class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2 group-hover:text-orange-200 flex justify-between">
                        Categories
                        <svg class="w-4 h-4 text-slate-300 group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </span>
                    <span class="text-4xl font-black text-gray-900 group-hover:text-white transition-colors">{{ \App\Models\Category::count() }}</span>
                </a>
                <a href="{{ route('admin.brands.index') }}" class="block bg-white p-8 rounded-[2rem] shadow-xl border border-gray-100 group hover:bg-pink-500 transition-all duration-500">
                    <span class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2 group-hover:text-pink-200 flex justify-between">
                        Brands
                        <svg class="w-4 h-4 text-slate-300 group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </span>
                    <span class="text-4xl font-black text-gray-900 group-hover:text-white transition-colors">{{ \App\Models\Brand::count() }}</span>
                </a>
            </div>

            <!-- Admin Quick Links -->
            <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-5 gap-4 mb-8">
                <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-4 bg-white p-6 rounded-[1.5rem] shadow-lg border border-gray-100 hover:bg-indigo-50 hover:border-indigo-100 transition-all group">
                    <div class="w-12 h-12 bg-indigo-100 rounded-2xl flex items-center justify-center group-hover:bg-indigo-600 transition-colors">
                        <svg class="w-6 h-6 text-indigo-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Manage</p>
                        <p class="font-black text-gray-900 group-hover:text-indigo-600 transition-colors">Orders</p>
                    </div>
                </a>
                <a href="{{ route('admin.inventory.index') }}" class="flex items-center gap-4 bg-white p-6 rounded-[1.5rem] shadow-lg border border-gray-100 hover:bg-sky-50 hover:border-sky-100 transition-all group">
                    <div class="w-12 h-12 bg-sky-100 rounded-2xl flex items-center justify-center group-hover:bg-sky-600 transition-colors">
                        <svg class="w-6 h-6 text-sky-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Manage</p>
                        <p class="font-black text-gray-900 group-hover:text-sky-600 transition-colors">Inventory</p>
                    </div>
                </a>
                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-4 bg-white p-6 rounded-[1.5rem] shadow-lg border border-gray-100 hover:bg-purple-50 hover:border-purple-100 transition-all group">
                    <div class="w-12 h-12 bg-purple-100 rounded-2xl flex items-center justify-center group-hover:bg-purple-600 transition-colors">
                        <svg class="w-6 h-6 text-purple-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Manage</p>
                        <p class="font-black text-gray-900 group-hover:text-purple-600 transition-colors">Users</p>
                    </div>
                </a>
                <a href="{{ route('admin.reports.index') }}" class="flex items-center gap-4 bg-white p-6 rounded-[1.5rem] shadow-lg border border-gray-100 hover:bg-green-50 hover:border-green-100 transition-all group">
                    <div class="w-12 h-12 bg-green-100 rounded-2xl flex items-center justify-center group-hover:bg-green-600 transition-colors">
                        <svg class="w-6 h-6 text-green-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">View</p>
                        <p class="font-black text-gray-900 group-hover:text-green-600 transition-colors">Reports</p>
                    </div>
                </a>
                <a href="{{ route('admin.promo-codes.index') }}" class="flex items-center gap-4 bg-white p-6 rounded-[1.5rem] shadow-lg border border-gray-100 hover:bg-yellow-50 hover:border-yellow-100 transition-all group">
                    <div class="w-12 h-12 bg-yellow-100 rounded-2xl flex items-center justify-center group-hover:bg-yellow-500 transition-colors">
                        <svg class="w-6 h-6 text-yellow-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Manage</p>
                        <p class="font-black text-gray-900 group-hover:text-yellow-600 transition-colors">Promo Codes</p>
                    </div>
                </a>
                <a href="{{ route('admin.riders.index') }}" class="flex items-center gap-4 bg-white p-6 rounded-[1.5rem] shadow-lg border border-gray-100 hover:bg-emerald-50 hover:border-emerald-100 transition-all group">
                    <div class="w-12 h-12 bg-emerald-100 rounded-2xl flex items-center justify-center group-hover:bg-emerald-600 transition-colors">
                        <svg class="w-6 h-6 text-emerald-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Manage</p>
                        <p class="font-black text-gray-900 group-hover:text-emerald-600 transition-colors">Riders</p>
                    </div>
                </a>
            </div>

            <!-- Recent Orders -->
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-[2.5rem] border border-gray-100">
                <div class="p-8 md:p-12">
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="text-2xl font-black text-gray-900 uppercase tracking-tight">Recent Activity</h3>
                        <a href="{{ route('admin.orders.index') }}" class="text-xs font-black text-indigo-600 uppercase tracking-widest hover:underline">View All Orders</a>
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
                                            @php $colors = ['pending'=>'yellow','processing'=>'blue','shipped'=>'indigo','delivered'=>'green','cancelled'=>'red']; $c = $colors[$order->status] ?? 'gray'; @endphp
                                            <span class="px-3 py-1 rounded-full text-[10px] uppercase font-black tracking-widest bg-{{ $c }}-100 text-{{ $c }}-600">{{ $order->status }}</span>
                                        </td>
                                        <td class="px-8 py-6">₱{{ number_format($order->total_amount, 2) }}</td>
                                        <td class="px-8 py-6 text-right">
                                            <a href="{{ route('admin.orders.show', $order) }}" class="px-4 py-2 bg-gray-100 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-indigo-50 hover:text-indigo-600 transition-colors">Manage</a>
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
