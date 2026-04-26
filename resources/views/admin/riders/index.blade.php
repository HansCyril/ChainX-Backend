<x-app-layout>
    <x-slot name="header">
        <div x-data="{ open: false }" x-cloak>
            <div class="flex items-center justify-between">
                <h2 class="font-black text-2xl text-gray-800 leading-tight uppercase tracking-tight">Rider Management</h2>
                <button @click="open = true" class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-700 shadow-lg shadow-indigo-600/30 transition-all active:scale-95 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    New Rider
                </button>
            </div>

            <!-- Add Rider Modal -->
            <div x-show="open" 
                 class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 backdrop-blur-sm" 
                 x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                <div @click.away="open = false" class="bg-white rounded-[2rem] overflow-hidden w-full max-w-lg shadow-2xl m-4 transform transition-all border border-gray-100">
                    <div class="px-8 py-6 border-b border-gray-50 flex justify-between items-center bg-gray-50/50">
                        <h3 class="text-xl font-black text-gray-900 uppercase tracking-tight">Add Rider</h3>
                        <button @click="open = false" class="text-gray-400 hover:text-red-500 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                    <form action="{{ route('admin.riders.store') }}" method="POST" class="p-8 space-y-6 text-left">
                        @csrf
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Rider Name</label>
                            <input type="text" name="name" required class="w-full rounded-xl border-gray-200 text-sm focus:border-indigo-500 focus:ring-indigo-500 bg-gray-50 font-medium">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Phone Number</label>
                            <input type="text" name="phone" placeholder="09xxxxxxxxx" class="w-full rounded-xl border-gray-200 text-sm focus:border-indigo-500 focus:ring-indigo-500 bg-gray-50 font-medium">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Vehicle Info</label>
                            <input type="text" name="vehicle" placeholder="e.g. Honda Click - Plate #123" class="w-full rounded-xl border-gray-200 text-sm focus:border-indigo-500 focus:ring-indigo-500 bg-gray-50 font-medium">
                        </div>
                        <div class="pt-4">
                            <button type="submit" class="w-full bg-indigo-600 text-white rounded-xl py-4 font-black text-xs uppercase tracking-[0.2em] hover:bg-indigo-700 shadow-xl shadow-indigo-600/30 transition-all active:scale-95">Add Rider</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-700 font-bold px-6 py-4 rounded-2xl">{{ session('success') }}</div>
            @endif

            <!-- Search -->
            <div class="bg-white rounded-[2rem] shadow-xl border border-gray-100 p-6 mb-6">
                <form method="GET" class="flex flex-wrap gap-4 items-end">
                    <div class="flex-1 min-w-[200px]">
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Search Riders</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Name, phone, or vehicle..." class="w-full rounded-xl border-gray-200 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="px-6 py-2.5 bg-gray-900 text-white rounded-xl text-sm font-black uppercase tracking-widest hover:bg-indigo-600 transition-colors">Search</button>
                        <a href="{{ route('admin.riders.index') }}" class="px-6 py-2.5 bg-gray-100 text-gray-600 rounded-xl text-sm font-black uppercase tracking-widest hover:bg-gray-200 transition-colors">Reset</a>
                    </div>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-[2.5rem] border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100 uppercase text-[10px] font-black text-gray-400 tracking-[0.2em]">
                                <th class="px-8 py-5">Rider</th>
                                <th class="px-8 py-5">Status</th>
                                <th class="px-8 py-5">Deliveries</th>
                                <th class="px-8 py-5 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 text-sm font-bold text-gray-700">
                            @forelse($riders as $rider)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-8 py-5">
                                        <div class="font-black text-gray-900">{{ $rider->name }}</div>
                                        <div class="text-xs text-gray-400 font-medium">{{ $rider->phone ?: 'No Phone' }}</div>
                                        <div class="text-[10px] text-indigo-500 uppercase tracking-wider">{{ $rider->vehicle ?: 'No Vehicle' }}</div>
                                    </td>
                                    <td class="px-8 py-5">
                                        @if($rider->is_active)
                                            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-green-100 text-green-600">Active</span>
                                        @else
                                            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-gray-100 text-gray-400">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="px-8 py-5 font-black text-gray-900">{{ $rider->orders_count }}</td>
                                    <td class="px-8 py-5 text-right flex items-center justify-end gap-2">
                                        <form method="POST" action="{{ route('admin.riders.toggle-status', $rider) }}">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="px-4 py-2 {{ $rider->is_active ? 'bg-amber-50 text-amber-600 hover:bg-amber-100' : 'bg-green-50 text-green-600 hover:bg-green-100' }} rounded-xl text-xs font-black uppercase tracking-widest transition-colors">
                                                {{ $rider->is_active ? 'Deactivate' : 'Activate' }}
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.riders.destroy', $rider) }}" onsubmit="return confirm('Delete this rider?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="px-4 py-2 bg-red-50 text-red-500 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-red-100 transition-colors">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="px-8 py-16 text-center text-gray-400 font-bold">No riders found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-8 py-6 border-t border-gray-50">{{ $riders->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
