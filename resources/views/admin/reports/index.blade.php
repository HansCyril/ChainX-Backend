<x-app-layout>
    <style>
        @media print {
            body {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            .no-print {
                display: none !important;
            }
        }
    </style>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <h2 class="font-black text-2xl text-gray-800 leading-tight uppercase tracking-tight italic">Business Intelligence & Reports</h2>
            <div class="flex items-center justify-between md:justify-end gap-6">
                <p class="text-sm font-bold text-gray-400 uppercase tracking-widest hidden sm:block">Real-time Performance Metrics</p>
                <a href="{{ route('admin.reports.export') }}" class="no-print inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest shadow-lg shadow-indigo-600/30 transition-all active:scale-95">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Download Excel
                </a>
            </div>
        </div>
    </x-slot>

    <div id="report-container" class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10">

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total Revenue -->
                <div class="bg-gray-900 rounded-[2rem] p-8 text-white shadow-2xl relative overflow-hidden group">
                    <div class="relative z-10">
                        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-white/40 mb-2">Total Revenue (Paid)</p>
                        <h3 class="text-4xl font-black">₱{{ number_format($stats['total_revenue'], 2) }}</h3>
                    </div>
                    <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:scale-125 transition-transform duration-700">
                        <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 14h-2v-2h2v2zm0-4h-2V7h2v5z"></path></svg>
                    </div>
                </div>

                <!-- Total Orders -->
                <div class="bg-white rounded-[2rem] p-8 border border-gray-100 shadow-xl group">
                    <p class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2">Total Orders</p>
                    <h3 class="text-4xl font-black text-gray-900 group-hover:text-indigo-600 transition-colors">{{ $stats['total_orders'] }}</h3>
                    <div class="mt-4 flex items-center gap-2">
                        <span class="text-xs font-bold text-yellow-600 bg-yellow-50 px-3 py-1 rounded-full">{{ $stats['pending_orders'] }} Pending</span>
                    </div>
                </div>

                <!-- Customers -->
                <div class="bg-white rounded-[2rem] p-8 border border-gray-100 shadow-xl group">
                    <p class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2">Active Customers</p>
                    <h3 class="text-4xl font-black text-gray-900 group-hover:text-red-500 transition-colors">{{ $stats['total_customers'] }}</h3>
                    <p class="mt-4 text-xs font-bold text-gray-400 italic">Excluding Admin accounts</p>
                </div>

                <!-- AOV -->
                <div class="bg-white rounded-[2rem] p-8 border border-gray-100 shadow-xl group">
                    <p class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2">Avg Order Value</p>
                    <h3 class="text-4xl font-black text-gray-900 group-hover:text-green-500 transition-colors">₱{{ number_format($stats['avg_order_value'], 2) }}</h3>
                    <p class="mt-4 text-xs font-bold text-green-500">Target: ₱200.00+</p>
                </div>
            </div>

            <!-- Charts & Tables Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                <!-- Top Selling -->
                <div class="bg-white rounded-[2.5rem] shadow-xl border border-gray-100 overflow-hidden">
                    <div class="px-10 py-8 border-b border-gray-50 flex justify-between items-center">
                        <h3 class="text-xl font-black text-gray-900 uppercase tracking-tight italic">Top Performance Products</h3>
                        <span class="text-[9px] font-black text-indigo-600 bg-indigo-50 px-3 py-1 rounded-full uppercase tracking-widest leading-none">Best Sellers</span>
                    </div>
                    <div class="p-8">
                        <div class="space-y-4">
                            @foreach($topProducts as $tp)
                                <div class="flex items-center gap-6 p-4 rounded-3xl hover:bg-gray-50/80 transition-all group">
                                    <div class="w-14 h-14 bg-gray-50 rounded-2xl flex-shrink-0 p-2 overflow-hidden border border-gray-100">
                                        <img src="{{ $tp->product->image ? asset('storage/'.$tp->product->image) : 'https://placehold.co/64x64' }}" class="w-full h-full object-contain group-hover:scale-110 transition-transform">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-black text-gray-900 truncate">{{ $tp->product->name }}</h4>
                                        <p class="text-xs text-gray-500 font-bold uppercase tracking-widest">{{ $tp->total_sold }} units sold</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-black text-indigo-600">₱{{ number_format($tp->total_revenue, 2) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Most Wishlisted (New Feature) -->
                <div class="bg-white rounded-[2.5rem] shadow-xl border border-gray-100 overflow-hidden">
                    <div class="px-10 py-8 border-b border-gray-50 flex justify-between items-center bg-gray-50/50">
                        <h3 class="text-xl font-black text-gray-900 uppercase tracking-tight italic">Customer Interest (Wishlist)</h3>
                        <span class="text-[9px] font-black text-red-600 bg-red-50 px-3 py-1 rounded-full uppercase tracking-widest leading-none">Wishlist Popularity</span>
                    </div>
                    <div class="p-8">
                        <div class="space-y-4">
                            @foreach($mostWishlisted as $wp)
                                <div class="flex items-center gap-6 p-4 rounded-3xl hover:bg-red-50/30 transition-all group">
                                    <div class="w-14 h-14 bg-white rounded-2xl flex-shrink-0 p-2 overflow-hidden border border-gray-100 shadow-sm relative">
                                        <img src="{{ $wp->image ? asset('storage/'.$wp->image) : 'https://placehold.co/64x64' }}" class="w-full h-full object-contain group-hover:rotate-6 transition-transform">
                                        <div class="absolute -top-1 -right-1 bg-red-500 w-3 h-3 rounded-full border-2 border-white"></div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-black text-gray-900 truncate">{{ $wp->name }}</h4>
                                        <div class="flex items-center gap-2 mt-1">
                                            <div class="h-1 flex-1 bg-gray-100 rounded-full overflow-hidden">
                                                <div class="h-full bg-red-500" style="width: {{ min(100, $wp->wishlists_count * 10) }}%"></div>
                                            </div>
                                            <span class="text-[10px] font-black text-red-500 uppercase tracking-widest">{{ $wp->wishlists_count }} SAVES</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @if($mostWishlisted->isEmpty())
                                <p class="text-center py-20 text-gray-300 font-bold italic uppercase tracking-widest">No wishlist data available</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Revenue Trend -->
            <div class="bg-gray-900 rounded-[3rem] shadow-2xl p-12 text-white">
                <h3 class="text-2xl font-black mb-10 tracking-tight uppercase italic flex items-center gap-4">
                    <span class="w-12 h-1 bg-indigo-500 rounded-full"></span>
                    Revenue Lifecycle
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-8">
                    @foreach($revenueByMonth as $rm)
                        <div class="group flex flex-col items-center">
                            <div class="w-full mb-6 flex flex-col justify-end items-center h-40">
                                <div class="w-12 bg-indigo-500 rounded-2xl group-hover:bg-indigo-400 transition-all duration-500 shadow-lg shadow-indigo-500/20" 
                                     style="height: {{ ($rm->revenue / max(1, $revenueByMonth->max('revenue'))) * 100 }}%"></div>
                            </div>
                            <p class="text-[10px] font-black uppercase tracking-[0.2em] text-white/40 mb-1">{{ \Carbon\Carbon::parse($rm->month . '-01')->format('M Y') }}</p>
                            <p class="font-black text-lg tracking-tighter">₱{{ number_format($rm->revenue, 0) }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
            
        </div>
    </div>


</x-app-layout>
