<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-800 leading-tight uppercase tracking-tight">Promo Codes</h2>
    </x-slot>

    <div class="py-12 bg-gray-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 font-bold px-6 py-4 rounded-2xl">{{ session('success') }}</div>
            @endif

            <!-- Create Form -->
            <div class="bg-white rounded-[2rem] shadow-xl border border-gray-100 p-8">
                <h3 class="text-lg font-black text-gray-900 uppercase tracking-tight mb-6">Create New Promo Code</h3>
                <form method="POST" action="{{ route('admin.promo-codes.store') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    @csrf
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Code *</label>
                        <input type="text" name="code" placeholder="SUMMER20" class="w-full rounded-xl border-gray-200 text-sm uppercase font-black focus:border-indigo-500 focus:ring-indigo-500 @error('code') border-red-400 @enderror" value="{{ old('code') }}">
                        @error('code')<p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Type *</label>
                        <select name="type" class="w-full rounded-xl border-gray-200 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="percentage" @selected(old('type')==='percentage')>Percentage (%)</option>
                            <option value="fixed" @selected(old('type')==='fixed')>Fixed (₱)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Value *</label>
                        <input type="number" name="value" placeholder="20" step="0.01" min="0.01" class="w-full rounded-xl border-gray-200 text-sm focus:border-indigo-500 focus:ring-indigo-500 @error('value') border-red-400 @enderror" value="{{ old('value') }}">
                        @error('value')<p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Min Order (₱)</label>
                        <input type="number" name="min_order_amount" placeholder="0" step="0.01" min="0" class="w-full rounded-xl border-gray-200 text-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('min_order_amount', 0) }}">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Max Uses</label>
                        <input type="number" name="max_uses" placeholder="Unlimited" min="1" class="w-full rounded-xl border-gray-200 text-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('max_uses') }}">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Expires At</label>
                        <input type="date" name="expires_at" class="w-full rounded-xl border-gray-200 text-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('expires_at') }}">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Description</label>
                        <input type="text" name="description" placeholder="Summer sale 20% off" class="w-full rounded-xl border-gray-200 text-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('description') }}">
                    </div>
                    <div class="sm:col-span-4 flex justify-end">
                        <button type="submit" class="px-8 py-3 bg-gray-900 text-white font-black uppercase tracking-widest text-sm rounded-xl hover:bg-indigo-600 transition-colors">Create Code</button>
                    </div>
                </form>
            </div>

            <!-- List -->
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-[2.5rem] border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100 uppercase text-[10px] font-black text-gray-400 tracking-[0.2em]">
                                <th class="px-8 py-5">Code</th>
                                <th class="px-8 py-5">Discount</th>
                                <th class="px-8 py-5">Min Order</th>
                                <th class="px-8 py-5">Uses</th>
                                <th class="px-8 py-5">Expires</th>
                                <th class="px-8 py-5">Status</th>
                                <th class="px-8 py-5 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 text-sm font-bold text-gray-700">
                            @forelse($codes as $code)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-8 py-5 font-black text-gray-900 font-mono tracking-widest">{{ $code->code }}</td>
                                    <td class="px-8 py-5">
                                        @if($code->type === 'percentage')
                                            <span class="text-indigo-600 font-black">{{ $code->value }}% OFF</span>
                                        @else
                                            <span class="text-green-600 font-black">₱{{ number_format($code->value, 2) }} OFF</span>
                                        @endif
                                    </td>
                                    <td class="px-8 py-5 text-gray-400">₱{{ number_format($code->min_order_amount, 2) }}</td>
                                    <td class="px-8 py-5">{{ $code->used_count }}{{ $code->max_uses ? ' / '.$code->max_uses : '' }}</td>
                                    <td class="px-8 py-5 text-gray-400">{{ $code->expires_at?->format('M d, Y') ?? '—' }}</td>
                                    <td class="px-8 py-5">
                                        @if($code->is_active && (!$code->expires_at || $code->expires_at->isFuture()))
                                            <span class="px-3 py-1 rounded-full text-[10px] uppercase font-black tracking-widest bg-green-100 text-green-600">Active</span>
                                        @else
                                            <span class="px-3 py-1 rounded-full text-[10px] uppercase font-black tracking-widest bg-red-100 text-red-500">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="px-8 py-5 text-right flex items-center justify-end gap-2">
                                        <form method="POST" action="{{ route('admin.promo-codes.toggle', $code) }}">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="px-4 py-2 bg-indigo-50 text-indigo-600 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-indigo-100 transition-colors">{{ $code->is_active ? 'Disable' : 'Enable' }}</button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.promo-codes.destroy', $code) }}" onsubmit="return confirm('Delete this promo code?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="px-4 py-2 bg-red-50 text-red-500 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-red-100 transition-colors">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="7" class="px-8 py-16 text-center text-gray-400 font-bold">No promo codes yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-8 py-6 border-t border-gray-50">{{ $codes->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
