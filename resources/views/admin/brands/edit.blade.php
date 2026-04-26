<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-slate-800 leading-tight uppercase tracking-tight">
            {{ __('Edit Brand: ') }} <span class="text-slate-400">{{ $brand->name }}</span>
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-[2.5rem] border border-slate-100 p-8 md:p-12">
                <form action="{{ route('admin.brands.update', $brand->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Brand Name</label>
                        <input type="text" name="name" value="{{ old('name', $brand->name) }}" class="w-full rounded-xl bg-slate-50 border-slate-200 text-slate-800 shadow-inner focus:border-red-500 focus:ring-red-500 transition-all font-bold p-4" required>
                        @error('name') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Description</label>
                        <textarea name="description" rows="4" class="w-full rounded-xl bg-slate-50 border-slate-200 text-slate-800 shadow-inner focus:border-red-500 focus:ring-red-500 transition-all font-medium p-4">{{ old('description', $brand->description) }}</textarea>
                        @error('description') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Brand Image / Logo</label>
                        
                        @if($brand->image)
                            <div class="mb-4">
                                <span class="block text-[10px] uppercase font-black tracking-widest text-slate-400 mb-2">Current Image:</span>
                                <img src="{{ Storage::url($brand->image) }}" class="w-32 h-32 object-contain rounded-xl border border-slate-200 bg-white shadow-sm" alt="Current brand image">
                            </div>
                        @endif
                        
                        <input type="file" name="image" accept="image/*" class="w-full rounded-xl bg-slate-50 border-slate-200 text-slate-800 shadow-inner focus:border-red-500 focus:ring-red-500 transition-all font-bold p-3 cursor-pointer file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-black file:uppercase file:tracking-widest file:bg-slate-200 file:text-slate-700 hover:file:bg-slate-300">
                        <span class="text-[10px] text-slate-400 mt-1 block">Leave empty to keep current image.</span>
                        @error('image') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="flex items-center space-x-3 p-6 bg-slate-50 rounded-2xl border border-slate-100">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $brand->is_active) ? 'checked' : '' }} class="w-6 h-6 rounded-md border-slate-300 text-red-600 focus:ring-red-500 cursor-pointer" id="is_active">
                        <label for="is_active" class="text-sm font-black uppercase tracking-widest text-slate-700 cursor-pointer">Active Brand</label>
                    </div>

                    <div class="pt-6 border-t border-slate-100 flex justify-end space-x-4">
                        <a href="{{ route('admin.brands.index') }}" class="px-6 py-4 bg-slate-100 text-slate-600 rounded-xl font-black uppercase tracking-widest text-sm hover:bg-slate-200 transition">Cancel</a>
                        <button type="submit" class="px-8 py-4 bg-gradient-to-r from-red-600 to-orange-500 text-white rounded-xl font-black uppercase tracking-widest text-sm hover:from-red-500 hover:to-orange-400 shadow-xl shadow-red-500/30 transform hover:-translate-y-1 transition">Update Brand</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
