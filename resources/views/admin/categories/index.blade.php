<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-2xl text-slate-800 leading-tight uppercase tracking-tight">
                {{ __('Categories') }}
            </h2>
            <a href="{{ route('admin.categories.create') }}" class="px-4 py-2 bg-gradient-to-r from-red-600 to-orange-500 rounded-xl text-xs font-black text-white uppercase tracking-widest hover:from-red-500 hover:to-orange-400 transition-all shadow-lg shadow-red-500/30">
                + Add Category
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
                                    <th class="px-8 py-5">Category Name</th>
                                    <th class="px-8 py-5">Slug Reference</th>
                                    <th class="px-8 py-5">Product Count</th>
                                    <th class="px-8 py-5">Status</th>
                                    <th class="px-8 py-5 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50 text-sm font-bold text-slate-700">
                                @forelse($categories as $category)
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="px-8 py-6">
                                            <div class="font-black text-slate-900">{{ $category->name }}</div>
                                        </td>
                                        <td class="px-8 py-6">
                                            <div class="text-[10px] text-slate-400 tracking-widest">{{ $category->slug }}</div>
                                        </td>
                                        <td class="px-8 py-6">
                                            <div class="font-black text-red-600">{{ $category->products()->count() }} items</div>
                                        </td>
                                        <td class="px-8 py-6">
                                            @if($category->is_active)
                                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-[10px] uppercase font-black tracking-widest">Active</span>
                                            @else
                                                <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-full text-[10px] uppercase font-black tracking-widest">Hidden</span>
                                            @endif
                                        </td>
                                        <td class="px-8 py-6 text-right space-x-2">
                                            <a href="{{ route('admin.categories.edit', $category->id) }}" class="inline-block px-4 py-2 bg-slate-100 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-slate-200 transition-colors">Edit</a>
                                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this category? Ensure it contains no products before deleting.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-4 py-2 bg-red-100/50 text-red-600 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-red-100 transition-colors">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-8 py-12 text-center text-slate-500 font-medium">
                                            No categories found in the database.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-6">
                        {{ $categories->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
