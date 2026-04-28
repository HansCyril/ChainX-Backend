<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-2xl text-slate-800 leading-tight uppercase tracking-tight">
                {{ __('Brands') }}
            </h2>
            <a href="{{ route('admin.brands.create') }}" class="px-4 py-2 bg-gradient-to-r from-red-600 to-orange-500 rounded-xl text-xs font-black text-white uppercase tracking-widest hover:from-red-500 hover:to-orange-400 transition-all shadow-lg shadow-red-500/30">
                + Add Brand
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
            
            @if(session('error'))
                <div class="mb-6 px-4 py-3 bg-red-100 border border-red-400 text-red-700 rounded-xl text-sm font-bold">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-[2.5rem] border border-slate-100">
                <div class="p-8 md:p-12">
                    <div class="overflow-x-auto rounded-3xl border border-slate-50">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50 uppercase text-[10px] font-black text-slate-400 tracking-[0.2em]">
                                    <th class="px-8 py-5">Image</th>
                                    <th class="px-8 py-5">Brand Name</th>
                                    <th class="px-8 py-5">Product Count</th>
                                    <th class="px-8 py-5">Status</th>
                                    <th class="px-8 py-5 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50 text-sm font-bold text-slate-700">
                                @forelse($brands as $brand)
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="px-8 py-6">
                                            @if($brand->image && Storage::disk('public')->exists($brand->image))
                                                <img src="{{ Storage::url($brand->image) }}" class="w-12 h-12 object-contain rounded-lg bg-white border border-slate-100" alt="{{ $brand->name }}">
                                            @else
                                                <div class="w-12 h-12 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400 text-[10px] font-black uppercase text-center leading-none p-1">
                                                    {{ $brand->image ? 'Missing File' : 'No Image' }}
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-8 py-6">
                                            <div class="font-black text-slate-900">{{ $brand->name }}</div>
                                            <div class="text-[10px] text-slate-400 tracking-widest mt-1">{{ $brand->slug }}</div>
                                        </td>
                                        <td class="px-8 py-6">
                                            <div class="font-black text-red-600">{{ $brand->products()->count() }} items</div>
                                        </td>
                                        <td class="px-8 py-6">
                                            @if($brand->is_active)
                                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-[10px] uppercase font-black tracking-widest">Active</span>
                                            @else
                                                <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-full text-[10px] uppercase font-black tracking-widest">Hidden</span>
                                            @endif
                                        </td>
                                        <td class="px-8 py-6 text-right space-x-2">
                                            <a href="{{ route('admin.brands.edit', $brand->id) }}" class="inline-block px-4 py-2 bg-slate-100 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-slate-200 transition-colors">Edit</a>
                                            <form action="{{ route('admin.brands.destroy', $brand->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this brand? Ensure it contains no products before deleting.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-4 py-2 bg-red-100/50 text-red-600 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-red-100 transition-colors">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-8 py-12 text-center text-slate-500 font-medium">
                                            No brands found in the database.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-6">
                        {{ $brands->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
