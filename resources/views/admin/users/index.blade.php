<x-app-layout>
    <x-slot name="header">
        <div x-data="{ open: false }" x-cloak>
            <div class="flex items-center justify-between">
                <h2 class="font-black text-2xl text-gray-800 leading-tight uppercase tracking-tight">User Management</h2>
                <button @click="open = true" class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-700 shadow-lg shadow-indigo-600/30 transition-all active:scale-95 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Create Account
                </button>
            </div>

            <!-- Add User Modal -->
            <div x-show="open" 
                 class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 backdrop-blur-sm" 
                 x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                <div @click.away="open = false" class="bg-white rounded-[2rem] overflow-hidden w-full max-w-lg shadow-2xl m-4 transform transition-all border border-gray-100">
                    <div class="px-8 py-6 border-b border-gray-50 flex justify-between items-center bg-gray-50/50">
                        <h3 class="text-xl font-black text-gray-900 uppercase tracking-tight">Create Account</h3>
                        <button @click="open = false" class="text-gray-400 hover:text-red-500 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                    <form action="{{ route('admin.users.store') }}" method="POST" class="p-8 space-y-6 text-left">
                        @csrf
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Full Name</label>
                            <input type="text" name="name" required class="w-full rounded-xl border-gray-200 text-sm focus:border-indigo-500 focus:ring-indigo-500 bg-gray-50 font-medium">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Email Address</label>
                            <input type="email" name="email" required class="w-full rounded-xl border-gray-200 text-sm focus:border-indigo-500 focus:ring-indigo-500 bg-gray-50 font-medium">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Password</label>
                                <input type="password" name="password" required minlength="8" class="w-full rounded-xl border-gray-200 text-sm focus:border-indigo-500 focus:ring-indigo-500 bg-gray-50 font-medium placeholder:text-gray-300" placeholder="Min 8 chars">
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Phone</label>
                                <input type="text" name="phone" class="w-full rounded-xl border-gray-200 text-sm focus:border-indigo-500 focus:ring-indigo-500 bg-gray-50 font-medium placeholder:text-gray-300" placeholder="Optional">
                            </div>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Address</label>
                            <input type="text" name="address" class="w-full rounded-xl border-gray-200 text-sm focus:border-indigo-500 focus:ring-indigo-500 bg-gray-50 font-medium placeholder:text-gray-300" placeholder="Street Address">
                        </div>
                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">City</label>
                                <input type="text" name="city" class="w-full rounded-xl border-gray-200 text-sm focus:border-indigo-500 focus:ring-indigo-500 bg-gray-50 font-medium">
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Province</label>
                                <input type="text" name="province" class="w-full rounded-xl border-gray-200 text-sm focus:border-indigo-500 focus:ring-indigo-500 bg-gray-50 font-medium">
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Zip</label>
                                <input type="text" name="postal_code" class="w-full rounded-xl border-gray-200 text-sm focus:border-indigo-500 focus:ring-indigo-500 bg-gray-50 font-medium">
                            </div>
                        </div>
                        <div class="flex flex-row items-center gap-4 mt-8 p-4 rounded-2xl border border-indigo-100 bg-indigo-50/30">
                            <input type="checkbox" name="is_admin" id="is_admin_check" value="1" class="w-5 h-5 rounded border-indigo-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer shadow-sm">
                            <div>
                                <label for="is_admin_check" class="block text-sm font-black text-indigo-900 cursor-pointer uppercase tracking-tight">Make this user an Admin</label>
                                <p class="text-[10px] text-indigo-500 font-bold mt-1 uppercase tracking-widest">Grants full access to the dashboard</p>
                            </div>
                        </div>
                        <div class="pt-4">
                            <button type="submit" class="w-full bg-indigo-600 text-white rounded-xl py-4 font-black text-xs uppercase tracking-[0.2em] hover:bg-indigo-700 shadow-xl shadow-indigo-600/30 transition-all active:scale-95">Create Account</button>
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
            @if(session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 font-bold px-6 py-4 rounded-2xl">{{ session('error') }}</div>
            @endif
            @if($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 font-bold px-6 py-4 rounded-2xl">
                    <ul class="list-disc list-inside text-sm">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Search/Filter -->
            <div class="bg-white rounded-[2rem] shadow-xl border border-gray-100 p-6 mb-6">
                <form method="GET" class="flex flex-wrap gap-4 items-end">
                    <div class="flex-1 min-w-[200px]">
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Search</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Name or email..." class="w-full rounded-xl border-gray-200 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div class="min-w-[140px]">
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Role</label>
                        <select name="role" class="w-full rounded-xl border-gray-200 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">All Roles</option>
                            <option value="admin" @selected(request('role')==='admin')>Admin Only</option>
                            <option value="customer" @selected(request('role')==='customer')>Customers Only</option>
                        </select>
                    </div>
                    <div class="min-w-[140px]">
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Status</label>
                        <select name="status" class="w-full rounded-xl border-gray-200 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="all" @selected($status==='all')>All Status</option>
                            <option value="active" @selected($status==='active')>Active Only</option>
                            <option value="archived" @selected($status==='archived')>Archived Only</option>
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="px-6 py-2.5 bg-gray-900 text-white rounded-xl text-sm font-black uppercase tracking-widest hover:bg-indigo-600 transition-colors">Filter</button>
                        <a href="{{ route('admin.users.index') }}" class="px-6 py-2.5 bg-gray-100 text-gray-600 rounded-xl text-sm font-black uppercase tracking-widest hover:bg-gray-200 transition-colors">Reset</a>
                    </div>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-[2.5rem] border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100 uppercase text-[10px] font-black text-gray-400 tracking-[0.2em]">
                                <th class="px-8 py-5">User</th>
                                <th class="px-8 py-5">Role</th>
                                <th class="px-8 py-5">Orders</th>
                                <th class="px-8 py-5">Joined</th>
                                <th class="px-8 py-5 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 text-sm font-bold text-gray-700">
                            @forelse($users as $user)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-8 py-5">
                                        <div class="font-black text-gray-900">{{ $user->name }}</div>
                                        <div class="text-xs text-gray-400 font-medium">{{ $user->email }}</div>
                                        @if($user->phone)
                                            <div class="text-[10px] text-indigo-500 font-bold mt-1 uppercase tracking-widest">{{ $user->phone }}</div>
                                        @endif
                                    </td>
                                    <td class="px-8 py-5">
                                        <div class="flex gap-2">
                                            @if($user->is_admin)
                                                <span class="px-3 py-1 rounded-full text-[10px] uppercase font-black tracking-widest bg-red-100 text-red-600">Admin</span>
                                            @else
                                                <span class="px-3 py-1 rounded-full text-[10px] uppercase font-black tracking-widest bg-gray-100 text-gray-500">Customer</span>
                                            @endif
                                            @if($user->is_archived)
                                                <span class="px-3 py-1 rounded-full text-[10px] uppercase font-black tracking-widest bg-amber-100 text-amber-600">Archived</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-8 py-5 font-black text-gray-900">{{ $user->orders_count }}</td>
                                    <td class="px-8 py-5 text-gray-400">{{ $user->created_at->format('M d, Y') }}</td>
                                    <td class="px-8 py-5 text-right flex items-center justify-end gap-2">
                                        @if($user->id !== auth()->id())
                                            <form method="POST" action="{{ route('admin.users.toggle-archive', $user) }}">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="px-4 py-2 {{ $user->is_archived ? 'bg-green-50 text-green-600 hover:bg-green-100' : 'bg-amber-50 text-amber-600 hover:bg-amber-100' }} rounded-xl text-xs font-black uppercase tracking-widest transition-colors">
                                                    {{ $user->is_archived ? 'Restore' : 'Archive' }}
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Delete this user?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="px-4 py-2 bg-red-50 text-red-500 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-red-100 transition-colors">Delete</button>
                                            </form>
                                        @else
                                            <span class="text-xs text-gray-300 font-bold">You</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="px-8 py-16 text-center text-gray-400 font-bold">No users found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-8 py-6 border-t border-gray-50">{{ $users->links() }}</div>
            </div>
        </div>
    </div>

</x-app-layout>
