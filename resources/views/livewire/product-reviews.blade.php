<div class="mt-20 border-t border-gray-100 pt-16">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-12 gap-6">
        <div>
            <h2 class="text-3xl font-black text-gray-900 tracking-tight flex items-center gap-4">
                Customer Reviews
                <span class="text-sm font-bold bg-indigo-50 text-indigo-600 px-4 py-1.5 rounded-full border border-indigo-100">{{ $reviews->count() }} total</span>
            </h2>
            <div class="flex items-center gap-2 mt-2">
                <div class="flex items-center">
                    @for($i = 1; $i <= 5; $i++)
                        <svg class="w-5 h-5 {{ $i <= floor($averageRating) ? 'text-yellow-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                    @endfor
                </div>
                <span class="text-lg font-black text-gray-900">{{ number_format($averageRating, 1) }}</span>
                <span class="text-gray-400 font-bold">average rating</span>
            </div>
        </div>

        @auth
            @if(!$showForm)
                <button wire:click="$set('showForm', true)" class="px-8 py-4 bg-slate-900 text-white rounded-2xl font-black uppercase text-xs tracking-widest hover:bg-indigo-600 transition-all shadow-xl shadow-slate-200">
                    Write a Review
                </button>
            @endif
        @else
            <a href="{{ route('login') }}" class="px-8 py-4 bg-gray-100 text-gray-600 rounded-2xl font-black uppercase text-xs tracking-widest hover:bg-gray-200 transition-all border border-gray-200">
                Sign in to Review
            </a>
        @endauth
    </div>

    @if($showForm)
        <div class="mb-20 bg-gray-50/50 p-8 md:p-12 rounded-[2.5rem] border border-gray-100 shadow-inner relative overflow-hidden group">
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-indigo-500 rounded-full blur-3xl opacity-10 group-hover:opacity-20 transition-opacity"></div>
            
            <h3 class="text-xl font-black text-gray-900 mb-8 uppercase tracking-tight">Your Feedback</h3>
            
            <form wire:submit.prevent="submitReview" class="space-y-8">
                <!-- Stars -->
                <div class="space-y-3">
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">Select Rating</label>
                    <div class="flex items-center gap-4">
                        @for($i = 1; $i <= 5; $i++)
                            <button type="button" wire:click="$set('rating', {{ $i }})" class="focus:outline-none transform transition hover:scale-125">
                                <svg class="w-10 h-10 {{ $i <= $rating ? 'text-yellow-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            </button>
                        @endfor
                    </div>
                </div>

                <!-- Comment -->
                <div class="space-y-3">
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">Your Experience</label>
                    <textarea wire:model="comment" rows="6" class="w-full bg-white border-2 border-slate-100 rounded-3xl p-6 text-gray-700 font-medium focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 transition-all resize-none placeholder:text-gray-300" placeholder="What do you think about this product?"></textarea>
                    <x-input-error :messages="$errors->get('comment')" />
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="bg-indigo-600 text-white px-10 py-4 rounded-2xl font-black uppercase text-xs tracking-[0.2em] hover:bg-indigo-700 shadow-xl shadow-indigo-200 transition-all active:scale-95">
                        Post Review
                    </button>
                    <button type="button" wire:click="$set('showForm', false)" class="text-gray-400 font-bold hover:text-gray-900 transition-colors px-6">Cancel</button>
                </div>
            </form>
        </div>
    @endif

    <!-- Review List -->
    <div class="space-y-8">
        @forelse($reviews as $review)
            <div class="bg-white border border-gray-100 p-8 rounded-[2rem] shadow-sm hover:shadow-xl transition-all duration-500 group">
                <div class="flex justify-between items-start mb-6">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-gray-100 rounded-2xl flex items-center justify-center font-black text-indigo-600 uppercase border border-gray-200">
                            {{ substr($review->user->name, 0, 1) }}
                        </div>
                        <div>
                            <h4 class="font-black text-gray-900 uppercase tracking-widest text-sm">{{ $review->user->name }}</h4>
                            <p class="text-[10px] font-bold text-gray-400 italic">{{ $review->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-1 bg-yellow-50 px-3 py-1.5 rounded-xl border border-yellow-100 group-hover:scale-110 transition-transform">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-3.5 h-3.5 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        @endfor
                    </div>
                </div>

                <p class="text-gray-600 font-medium leading-relaxed italic">"{{ $review->comment }}"</p>
            </div>
        @empty
            <div class="text-center py-20 bg-gray-50 rounded-[3rem] border-2 border-dashed border-gray-200">
                <div class="mb-4 inline-block p-4 bg-white rounded-3xl shadow-lg border border-gray-100">
                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                </div>
                <p class="text-gray-400 font-bold italic">No reviews yet. Be the first to share your experience!</p>
            </div>
        @endforelse
    </div>
</div>
