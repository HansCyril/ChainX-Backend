<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-800 leading-tight uppercase tracking-tight">Inventory Management</h2>
    </x-slot>

    <div class="py-12 bg-gray-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-700 font-bold px-6 py-4 rounded-2xl">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 font-bold px-6 py-4 rounded-2xl">{{ session('error') }}</div>
            @endif

            <!-- Search/Filter -->
            <div class="bg-white rounded-[2rem] shadow-xl border border-gray-100 p-6 mb-8 flex flex-wrap lg:flex-nowrap gap-6 items-end justify-between">
                <form method="GET" class="flex flex-wrap gap-4 items-end flex-1">
                    <div class="flex-1 min-w-[200px]">
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Search Product</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name..." class="w-full rounded-xl border-gray-200 text-sm focus:border-indigo-500 focus:ring-indigo-500 font-bold">
                    </div>
                    <div class="min-w-[150px]">
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Stock Level</label>
                        <select name="stock" class="w-full rounded-xl border-gray-200 text-sm focus:border-indigo-500 focus:ring-indigo-500 font-bold">
                            <option value="all" @selected($stockFilter === 'all')>All Items</option>
                            <option value="low" @selected($stockFilter === 'low')>Low Stock (1-5)</option>
                            <option value="out" @selected($stockFilter === 'out')>Out of Stock (0)</option>
                        </select>
                    </div>
                    <div>
                        <button type="submit" class="px-6 py-2.5 bg-gray-900 text-white rounded-xl text-sm font-black uppercase tracking-widest hover:bg-indigo-600 shadow-lg transition-all active:scale-95">Filter</button>
                    </div>
                </form>
            </div>

            <!-- Inventory Grid -->
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-[2.5rem] border border-gray-100 p-8">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-gray-100 uppercase text-[10px] font-black text-gray-400 tracking-[0.2em]">
                                <th class="py-4 px-4 w-12">Image</th>
                                <th class="py-4 px-4">Item Name / Category</th>
                                <th class="py-4 px-4">Price</th>
                                <th class="py-4 px-4 text-center">Status</th>
                                <th class="py-4 px-4 w-48 text-right">Stock Qty</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 text-sm font-bold text-gray-700">
                            @forelse($products as $product)
                                <tr class="hover:bg-gray-50/50 transition-colors group">
                                    <td class="py-4 px-4">
                                        <div class="w-12 h-12 bg-gray-50 rounded-xl overflow-hidden border border-gray-100">
                                            <img src="{{ $product->image ? asset('storage/'.$product->image) : 'https://placehold.co/48x48?text=Img' }}" class="w-full h-full object-contain">
                                        </div>
                                    </td>
                                    <td class="py-4 px-4">
                                        <p class="font-black text-gray-900 truncate max-w-xs">{{ $product->name }}</p>
                                        <p class="text-[10px] text-indigo-500 font-bold uppercase tracking-widest mt-1">{{ optional($product->category)->name ?? 'No Category' }}</p>
                                    </td>
                                    <td class="py-4 px-4">
                                        <div class="font-black text-gray-900">₱{{ number_format($product->price, 2) }}</div>
                                    </td>
                                    <td class="py-4 px-4 text-center">
                                        @if($product->quantity > 5)
                                            <span class="inline-block px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest bg-green-100 text-green-600">In Stock</span>
                                        @elseif($product->quantity > 0)
                                            <span class="inline-block px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest bg-yellow-100 text-yellow-600 animate-pulse">Low Stock</span>
                                        @else
                                            <span class="inline-block px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest bg-red-100 text-red-600 animate-pulse">Out of Stock</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-4 text-right">
                                        <form method="POST" action="{{ route('admin.inventory.update', $product) }}" class="flex items-center justify-end gap-2">
                                            @csrf
                                            @method('PATCH')
                                            <input type="number" name="quantity" value="{{ $product->quantity }}" min="0" class="w-20 text-center rounded-xl border-gray-200 text-sm font-black focus:ring-indigo-500 focus:border-indigo-500 p-2">
                                            <button type="submit" class="px-3 py-2 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-600 hover:text-white transition-all active:scale-95 shadow-sm">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-12 text-center text-gray-400 font-black tracking-widest uppercase text-xs">No products found matching criteria.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-8 border-t border-gray-50 pt-6">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
