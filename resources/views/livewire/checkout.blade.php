<div class="py-12 bg-gray-50/30">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Left: Checkout Form -->
            <div class="space-y-8">
                <div class="bg-white overflow-hidden shadow-2xl sm:rounded-[2rem] border border-gray-100 p-8 md:p-12">
                    <h2 class="text-3xl font-black text-gray-900 mb-8 tracking-tight uppercase italic">Shipping Information</h2>
                    
                    <div class="space-y-6">
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Shipping Address</label>
                            <textarea wire:model="address" rows="4" placeholder="Street name, City, State, ZIP..." class="w-full rounded-2xl border-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-4 px-6 text-sm bg-gray-50/50"></textarea>
                            @error('address') <span class="text-red-500 text-xs font-bold mt-1">{{ $message }}</span> @error
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Order Notes (Optional)</label>
                            <textarea wire:model="notes" rows="2" placeholder="Special instructions for delivery..." class="w-full rounded-2xl border-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-4 px-6 text-sm bg-gray-50/50"></textarea>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-2xl sm:rounded-[2rem] border border-gray-100 p-8 md:p-12">
                    <h2 class="text-3xl font-black text-gray-900 mb-8 tracking-tight uppercase italic">Payment Method</h2>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <label class="relative flex flex-col p-6 cursor-pointer rounded-2xl border-2 {{ $paymentMethod === 'stripe' ? 'border-indigo-600 bg-indigo-50/30' : 'border-gray-50 bg-gray-50/30' }} transition-all group">
                            <input type="radio" wire:model.live="paymentMethod" value="stripe" class="sr-only">
                            <span class="font-black text-gray-900 uppercase tracking-widest mb-1">Stripe / Card</span>
                            <span class="text-[10px] text-gray-400 font-bold">Credit or Debit Card</span>
                            @if($paymentMethod === 'stripe')
                                <div class="absolute top-4 right-4 text-indigo-600">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                </div>
                            @endif
                        </label>

                        <label class="relative flex flex-col p-6 cursor-pointer rounded-2xl border-2 {{ $paymentMethod === 'paymongo' ? 'border-indigo-600 bg-indigo-50/30' : 'border-gray-50 bg-gray-50/30' }} transition-all group">
                            <input type="radio" wire:model.live="paymentMethod" value="paymongo" class="sr-only">
                            <span class="font-black text-gray-900 uppercase tracking-widest mb-1">PayMongo</span>
                            <span class="text-[10px] text-gray-400 font-bold">GCash, Maya, GrabPay</span>
                            @if($paymentMethod === 'paymongo')
                                <div class="absolute top-4 right-4 text-indigo-600">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                </div>
                            @endif
                        </label>
                    </div>
                </div>
            </div>

            <!-- Right: Order Summary -->
            <div>
                <div class="bg-gray-900 overflow-hidden shadow-2xl sm:rounded-[2.5rem] p-8 md:p-12 text-white sticky top-8">
                    <h2 class="text-3xl font-black mb-12 tracking-tight uppercase italic border-b border-white/10 pb-6 text-center">Your Order</h2>
                    
                    <div class="space-y-6 mb-12 max-h-80 overflow-y-auto pr-4 custom-scrollbar">
                        @foreach($cart as $item)
                            <div class="flex items-center gap-6">
                                <div class="w-16 h-16 bg-white/5 rounded-2xl overflow-hidden flex-shrink-0 p-2">
                                    <img src="{{ $item['image'] }}" class="w-full h-full object-contain">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-bold truncate text-sm">{{ $item['name'] }}</h4>
                                    <p class="text-[10px] font-black text-gray-500 uppercase tracking-widest">Qty: {{ $item['quantity'] }}</p>
                                </div>
                                <div class="text-right">
                                    <span class="font-black text-sm">${{ number_format(($item['sale_price'] ?? $item['price']) * $item['quantity'], 2) }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="space-y-4 mb-10">
                        <div class="flex justify-between text-gray-400 font-bold uppercase tracking-widest text-xs">
                            <span>Subtotal</span>
                            <span class="text-white">${{ number_format($total, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-gray-400 font-bold uppercase tracking-widest text-xs">
                            <span>Shipping</span>
                            <span class="text-green-400 italic">calculated at checkout</span>
                        </div>
                        <div class="flex justify-between items-baseline pt-6 border-t border-white/10">
                            <span class="text-xl font-bold text-gray-400">Total</span>
                            <span class="text-5xl font-black text-white tracking-tighter">${{ number_format($total, 2) }}</span>
                        </div>
                    </div>

                    <button wire:click="placeOrder" class="w-full bg-white text-gray-900 font-black uppercase tracking-[0.3em] text-sm py-6 rounded-3xl hover:bg-indigo-500 hover:text-white transition-all shadow-2xl active:scale-95 flex items-center justify-center gap-3">
                        Place Order
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </button>
                    <p class="mt-6 text-center text-[10px] text-gray-500 font-bold uppercase tracking-[0.2em]">By clicking you agree to our terms of service</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.custom-scrollbar::-webkit-scrollbar { width: 4px; }
.custom-scrollbar::-webkit-scrollbar-track { background: rgba(255,255,255,0.05); border-radius: 10px; }
.custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 10px; }
.custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.2); }
</style>
