<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-slate-800 leading-tight uppercase tracking-tight">
            {{ __('Edit Category: ') }} <span class="text-red-600">{{ $category->name }}</span>
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-[2.5rem] border border-slate-100 p-8 md:p-12">
                <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" class="space-y-8">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="col-span-1 md:col-span-2">
                            <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Category Name</label>
                            <input type="text" name="name" value="{{ old('name', $category->name) }}" class="w-full rounded-xl bg-slate-50 border-slate-200 text-slate-800 shadow-inner focus:border-red-500 focus:ring-red-500 transition-all font-bold p-4" required>
                            @error('name') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                            <p class="text-[10px] uppercase font-bold text-slate-400 mt-2 tracking-widest">A unique URL slug will be automatically updated from the category name.</p>
                        </div>

                        <div class="col-span-1 md:col-span-2 flex space-x-6 items-center p-6 bg-slate-50 rounded-2xl border border-slate-100">
                            <label class="flex items-center space-x-3 cursor-pointer">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }} class="w-6 h-6 rounded-md border-slate-300 text-red-600 focus:ring-red-500">
                                <span class="text-sm font-black uppercase tracking-widest text-slate-700">Display Category Visually on Storefront</span>
                            </label>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-slate-100 flex justify-end space-x-4">
                        <a href="{{ route('admin.categories.index') }}" class="px-6 py-4 bg-slate-100 text-slate-600 rounded-xl font-black uppercase tracking-widest text-sm hover:bg-slate-200 transition">Cancel</a>
                        <button type="submit" class="px-8 py-4 bg-gradient-to-r from-red-600 to-orange-500 text-white rounded-xl font-black uppercase tracking-widest text-sm hover:from-red-500 hover:to-orange-400 shadow-xl shadow-red-500/30 transform hover:-translate-y-1 transition">Update Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
