<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-slate-800 leading-tight uppercase tracking-tight">
            {{ __('Add New Brand') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-[2.5rem] border border-slate-100 p-8 md:p-12">
                <form action="{{ route('admin.brands.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="col-span-1 md:col-span-2">
                            <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Brand Name</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="w-full rounded-xl bg-slate-50 border-slate-200 text-slate-800 shadow-inner focus:border-red-500 focus:ring-red-500 transition-all font-bold p-4" required>
                            @error('name') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                            <p class="text-[10px] uppercase font-bold text-slate-400 mt-2 tracking-widest">A unique URL slug will be automatically generated from the brand name.</p>
                        </div>

                        <div class="col-span-1 md:col-span-2">
                            <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Brand Image / Logo</label>
                            <div class="relative group">
                                <input type="file" name="image" class="w-full rounded-xl bg-slate-50 border-slate-200 text-slate-800 shadow-inner focus:border-red-500 focus:ring-red-500 transition-all font-bold p-4 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-black file:uppercase file:bg-red-50 file:text-red-700 hover:file:bg-red-100 cursor-pointer">
                            </div>
                            @error('image') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-span-1 md:col-span-2 flex space-x-6 items-center p-6 bg-slate-50 rounded-2xl border border-slate-100">
                            <label class="flex items-center space-x-3 cursor-pointer">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }} class="w-6 h-6 rounded-md border-slate-300 text-red-600 focus:ring-red-500">
                                <span class="text-sm font-black uppercase tracking-widest text-slate-700">Display Brand Visually on Storefront</span>
                            </label>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-slate-100 flex justify-end space-x-4">
                        <a href="{{ route('admin.brands.index') }}" class="px-6 py-4 bg-slate-100 text-slate-600 rounded-xl font-black uppercase tracking-widest text-sm hover:bg-slate-200 transition">Cancel</a>
                        <button type="submit" class="px-8 py-4 bg-gradient-to-r from-red-600 to-orange-500 text-white rounded-xl font-black uppercase tracking-widest text-sm hover:from-red-500 hover:to-orange-400 shadow-xl shadow-red-500/30 transform hover:-translate-y-1 transition">Save Brand</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
