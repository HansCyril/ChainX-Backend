<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-black text-2xl text-gray-800 leading-tight uppercase tracking-tight">
                Order Detail: #{{ $order->order_number }}
            </h2>
            <a href="{{ route('admin.orders.index') }}" class="px-6 py-2 bg-gray-100 text-gray-600 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-gray-200 transition-colors">Back to Orders</a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 font-bold px-6 py-4 rounded-2xl">{{ session('success') }}</div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Items List -->
                <div class="lg:col-span-2 space-y-8">
                    <div class="bg-white rounded-[2rem] shadow-xl border border-gray-100 overflow-hidden">
                        <div class="px-8 py-6 border-b border-gray-50 bg-gray-50/30">
                            <h3 class="text-lg font-black text-gray-900 uppercase tracking-tight italic">Ordered Items</h3>
                        </div>
                        <div class="p-8 space-y-6">
                            @foreach($order->items as $item)
                                <div class="flex items-center gap-6 group">
                                    <div class="w-16 h-16 bg-gray-50 rounded-2xl border border-gray-100 overflow-hidden p-2 flex-shrink-0 group-hover:scale-110 transition-transform">
                                        <img src="{{ $item->product?->image ? asset('storage/'.$item->product->image) : 'https://placehold.co/64x64?text=P' }}" class="w-full h-full object-contain">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-black text-gray-900 truncate">{{ $item->product?->name ?? 'Deleted Product' }}</h4>
                                        <p class="text-xs text-gray-400 font-bold">Qty: {{ $item->quantity }} × ₱{{ number_format($item->price, 2) }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-black text-gray-900">₱{{ number_format($item->quantity * $item->price, 2) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="px-8 py-6 bg-gray-50/30 border-t border-gray-50">
                            <div class="space-y-2">
                                <div class="flex justify-between text-xs font-bold text-gray-400 uppercase tracking-wider">
                                    <span>Subtotal</span>
                                    <span>₱{{ number_format($order->subtotal ?: $order->total_amount, 2) }}</span>
                                </div>
                                @if($order->discount_amount > 0)
                                <div class="flex justify-between text-xs font-bold text-green-500 uppercase tracking-wider">
                                    <span>Discount (Promo)</span>
                                    <span>-₱{{ number_format($order->discount_amount, 2) }}</span>
                                </div>
                                @endif
                                <div class="flex justify-between font-black text-2xl text-gray-900 pt-2 border-t border-gray-100">
                                    <span>Total Amount</span>
                                    <span>₱{{ number_format($order->total_amount, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Info -->
                    <div class="bg-white rounded-[2rem] shadow-xl border border-gray-100 p-8">
                        <h3 class="text-lg font-black text-gray-900 uppercase tracking-tight italic mb-6">Logistics & Shipping</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Shipping Address</h4>
                                <div class="p-4 bg-gray-50 rounded-2xl text-sm font-bold text-gray-700 leading-relaxed">
                                    {{ $order->shipping_address }}
                                </div>
                            </div>
                            <div>
                                <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Customer Notes</h4>
                                <div class="p-4 bg-gray-50 rounded-2xl text-sm font-bold text-gray-400 italic">
                                    {{ $order->notes ?: 'No notes provided' }}
                                </div>
                            </div>
                        </div>
                        
                        @if($order->shipped_at || $order->tracking_number)
                        <div class="mt-8 pt-8 border-t border-gray-100 flex gap-12">
                            <div>
                                <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Tracking Number</h4>
                                <p class="font-black text-gray-900 font-mono">{{ $order->tracking_number ?: 'Not yet issued' }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Admin Actions / Status -->
                <div class="space-y-8">
                    <div class="bg-white rounded-[2rem] shadow-xl border border-gray-100 p-8">
                        <h3 class="text-lg font-black text-gray-900 uppercase tracking-tight italic mb-8">Manage Order</h3>
                        
                        <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="space-y-6">
                            @csrf @method('PATCH')
                            
                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Order Status</label>
                                <select name="status" class="w-full rounded-xl border-gray-200 text-sm font-black focus:border-indigo-500 focus:ring-indigo-500">
                                    @foreach(['pending','processing','shipped','delivered','cancelled'] as $s)
                                        <option value="{{ $s }}" @selected($order->status === $s)>{{ ucfirst($s) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Payment Status</label>
                                <select name="payment_status" class="w-full rounded-xl border-gray-200 text-sm font-black focus:border-indigo-500 focus:ring-indigo-500">
                                    @foreach(['pending','paid','failed','refunded'] as $ps)
                                        <option value="{{ $ps }}" @selected($order->payment_status === $ps)>{{ ucfirst($ps) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <hr class="border-gray-50 my-6">

                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Tracking Number</label>
                                <input type="text" name="tracking_number" value="{{ old('tracking_number', $order->tracking_number) }}" placeholder="Enter ID" class="w-full rounded-xl border-gray-200 text-sm font-mono focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Estimated Delivery</label>
                                <input type="date" name="estimated_delivery_at" value="{{ $order->estimated_delivery_at?->format('Y-m-d') }}" class="w-full rounded-xl border-gray-200 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Assign Rider</label>
                                <select name="rider_id" class="w-full rounded-xl border-gray-200 text-sm font-black focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">No Rider Assigned</option>
                                    @foreach($riders as $rider)
                                        <option value="{{ $rider->id }}" @selected($order->rider_id === $rider->id)>
                                            {{ $rider->name }} ({{ $rider->vehicle ?: 'No Vehicle Info' }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="w-full bg-indigo-600 text-white font-black uppercase tracking-[0.2em] text-xs py-5 rounded-2xl hover:bg-indigo-500 shadow-xl shadow-indigo-100 transition-all active:scale-95">Update Order Info</button>
                        </form>
                    </div>

                    <div class="bg-indigo-900 rounded-[2rem] shadow-xl p-8 text-white">
                        <h4 class="text-[10px] font-black text-white/40 uppercase tracking-widest mb-4">Customer Info</h4>
                        <p class="font-black text-lg">{{ $order->user->name }}</p>
                        <p class="text-sm text-indigo-300 font-bold mb-6">{{ $order->user->email }}</p>
                        <hr class="border-white/10 mb-6">
                        <p class="text-[10px] font-black text-white/40 uppercase tracking-widest">Registered Date</p>
                        <p class="text-xs font-bold">{{ $order->user->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
