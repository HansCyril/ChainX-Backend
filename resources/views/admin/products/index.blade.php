<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-2xl text-slate-800 leading-tight uppercase tracking-tight">
                {{ __('Products') }}
            </h2>
            <a href="{{ route('admin.products.create') }}" class="px-4 py-2 bg-gradient-to-r from-red-600 to-orange-500 rounded-xl text-xs font-black text-white uppercase tracking-widest hover:from-red-500 hover:to-orange-400 transition-all shadow-lg shadow-red-500/30">
                + Add Product
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 px-4 py-3 bg-green-100 border border-green-400 text-green-700 rounded-xl text-sm font-bold">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-[2.5rem] border border-slate-100">
                <div class="p-8 md:p-12">
                    <div class="overflow-x-auto rounded-3xl border border-slate-50">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50 uppercase text-[10px] font-black text-slate-400 tracking-[0.2em]">
                                    <th class="px-8 py-5">Product Info</th>
                                    <th class="px-8 py-5">Brand & Category</th>
                                    <th class="px-8 py-5">Price</th>
                                    <th class="px-8 py-5">Stock</th>
                                    <th class="px-8 py-5">Status</th>
                                    <th class="px-8 py-5 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50 text-sm font-bold text-slate-700">
                                @forelse($products as $product)
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="px-8 py-6">
                                            <div class="flex items-center space-x-4">
                                                @if($product->image)
                                                    <img src="{{ asset('storage/' . $product->image) }}" class="w-12 h-12 rounded-lg object-cover border border-slate-200" alt="{{ $product->name }}">
                                                @else
                                                    <div class="w-12 h-12 rounded-lg bg-slate-100 flex items-center justify-center border border-slate-200">
                                                        <svg class="w-6 h-6 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                    </div>
                                                @endif
                                                <div>
                                                    <div class="font-black text-slate-900">{{ $product->name }}</div>
                                                    <div class="text-[10px] text-slate-400 uppercase tracking-widest mt-1">SKU: {{ $product->sku ?? 'N/A' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-8 py-6">
                                            <div>{{ $product->brand->name ?? 'None' }}</div>
                                            <div class="text-[10px] text-slate-400 uppercase tracking-widest mt-1">{{ $product->category->name ?? 'None' }}</div>
                                        </td>
                                        <td class="px-8 py-6">
                                            <div class="font-black text-red-600">₱{{ number_format($product->price, 2) }}</div>
                                        </td>
                                        <td class="px-8 py-6">
                                            {{ $product->quantity }} units
                                        </td>
                                        <td class="px-8 py-6">
                                            @if($product->is_active)
                                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-[10px] uppercase font-black tracking-widest">Active</span>
                                            @else
                                                <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-full text-[10px] uppercase font-black tracking-widest">Draft</span>
                                            @endif
                                        </td>
                                        <td class="px-8 py-6 text-right space-x-2">
                                            <a href="{{ route('admin.products.edit', $product->id) }}" class="inline-block px-4 py-2 bg-slate-100 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-slate-200 transition-colors">Edit</a>
                                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this product?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-4 py-2 bg-red-100/50 text-red-600 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-red-100 transition-colors">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-8 py-12 text-center text-slate-500 font-medium">
                                            No products found in the database.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-6">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
