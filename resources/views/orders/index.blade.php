<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <h2 class="font-black text-3xl text-gray-900 leading-tight tracking-tight">
                My Order History
            </h2>
            <div class="inline-flex items-center gap-2 bg-gray-900 text-white px-4 py-2 rounded-xl text-sm font-bold shadow-lg shadow-gray-200">
                <span class="w-2 h-2 bg-orange-500 rounded-full animate-pulse"></span>
                {{ $orders->total() }} Orders
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            @if($orders->count() > 0)
                <div class="space-y-8">
                    @foreach($orders as $order)
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden relative">
                            <!-- Order Info Banner -->
                            <div class="bg-gray-900 px-6 py-5 text-white grid grid-cols-2 md:grid-cols-4 gap-6 items-center">
                                <div>
                                    <p class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-1">Order No</p>
                                    <p class="text-lg font-black tracking-tight">{{ $order->order_number }}</p>
                                </div>
                                <div>
                                    <p class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-1">Date Placed</p>
                                    <p class="text-sm font-semibold">{{ $order->created_at->format('M d, Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-1">Status</p>
                                    @php
                                        $colors = ['pending'=>'yellow','processing'=>'blue','shipped'=>'indigo','delivered'=>'green','cancelled'=>'red'];
                                        $c = $colors[$order->status] ?? 'gray';
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-{{ $c }}-500 text-white shadow-sm shadow-{{ $c }}-500/20">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>
                                <div class="text-left md:text-right">
                                    <p class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-1">Total Paid</p>
                                    <p class="text-xl font-black text-orange-500">₱{{ number_format($order->total_amount, 2) }}</p>
                                </div>
                            </div>

                            <!-- Logistics Details -->
                            @if($order->tracking_number)
                            <div class="px-6 py-4 bg-gray-50 flex flex-wrap items-center gap-8 border-b border-gray-100">
                                <div class="flex items-center gap-3">
                                    <div class="p-2 bg-indigo-100 rounded-lg text-indigo-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-0.5">Carrier</p>
                                        <p class="text-sm font-bold text-gray-900">{{ $order->shipping_carrier }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="p-2 bg-indigo-100 rounded-lg text-indigo-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-0.5">Tracking ID</p>
                                        <p class="text-sm font-bold text-gray-900 font-mono">{{ $order->tracking_number }}</p>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Stepper Container -->
                            <div class="p-8 md:p-12 border-b border-gray-100">
                                @php
                                    $steps = ['pending','processing','shipped','delivered'];
                                    $stepIdx = array_search($order->status, $steps);
                                @endphp
                                <div class="relative flex items-center justify-between max-w-3xl mx-auto">
                                    <!-- Connecting Lines -->
                                    <div class="absolute top-1/2 left-0 w-full h-1 bg-gray-200 -translate-y-1/2 rounded-full overflow-hidden">
                                        <div class="h-full bg-orange-500 transition-all duration-700" style="width: {{ ($stepIdx / (count($steps)-1)) * 100 }}%"></div>
                                    </div>

                                    @foreach($steps as $i => $step)
                                        <div class="relative z-10 flex flex-col items-center">
                                            <div class="w-12 h-12 rounded-full flex items-center justify-center transition-all duration-500 border-4 
                                                {{ $i <= $stepIdx ? 'bg-orange-500 border-white text-white shadow-md' : 'bg-white border-gray-200 text-gray-400' }}">
                                                @if($i < $stepIdx || ($order->status === 'delivered' && $i === 3))
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                                @else
                                                    <span class="font-bold text-sm">{{ $i+1 }}</span>
                                                @endif
                                            </div>
                                            <div class="mt-4 text-center">
                                                <p class="text-[10px] font-bold uppercase tracking-widest {{ $i <= $stepIdx ? 'text-gray-900' : 'text-gray-400' }}">{{ $step }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Items Section -->
                            <div class="p-6 md:p-8">
                                <h4 class="text-xs font-bold text-gray-900 uppercase tracking-wider mb-6">Package Contents</h4>
                                <div class="space-y-4">
                                    @foreach($order->items as $item)
                                        <div class="flex items-center gap-4 p-4 rounded-xl hover:bg-gray-50 border border-transparent hover:border-gray-100 transition-colors">
                                            <div class="w-16 h-16 bg-white rounded-lg border border-gray-100 p-2 flex-shrink-0">
                                                <img src="{{ $item->product?->image ? asset('storage/'.$item->product->image) : 'https://placehold.co/100x100?text=P' }}" class="w-full h-full object-contain">
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <h5 class="font-bold text-gray-900 truncate text-sm">
                                                    {{ $item->product?->name ?? 'Deleted Product' }}
                                                </h5>
                                                <span class="text-xs font-medium text-gray-500">Qty: {{ $item->quantity }}</span>
                                            </div>
                                            <div class="text-right flex-shrink-0">
                                                <p class="font-bold text-gray-900 text-sm">₱{{ number_format($item->price * $item->quantity, 2) }}</p>
                                                @if($item->price < $item->product?->price)
                                                    <span class="bg-red-50 text-red-500 text-[9px] font-bold px-2 py-0.5 rounded-full uppercase">Sale</span>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-12">
                    {{ $orders->links() }}
                </div>
            @else
                <!-- No Orders State -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 py-24 text-center">
                    <div class="mb-8 inline-flex p-8 bg-orange-50 rounded-full text-orange-500">
                        <svg class="w-16 h-16 stroke-current" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </div>
                    <h2 class="text-3xl font-black text-gray-900 mb-4 tracking-tight">No orders yet</h2>
                    <p class="text-gray-500 mb-8 max-w-sm mx-auto font-medium">Head over to the shop and grab your first item to get started!</p>
                    <a href="{{ route('products.index') }}" class="inline-flex items-center bg-gray-900 text-white font-bold text-sm px-8 py-4 rounded-xl hover:bg-orange-600 transition-colors shadow-md">
                        Start Shopping
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
