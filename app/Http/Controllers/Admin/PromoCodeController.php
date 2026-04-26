<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PromoCode;
use Illuminate\Http\Request;

class PromoCodeController extends Controller
{
    public function index()
    {
        $codes = PromoCode::latest()->paginate(15);
        return view('admin.promo-codes.index', compact('codes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code'             => 'required|string|uppercase|unique:promo_codes,code',
            'description'      => 'nullable|string|max:255',
            'type'             => 'required|in:percentage,fixed',
            'value'            => 'required|numeric|min:0.01',
            'min_order_amount' => 'nullable|numeric|min:0',
            'max_uses'         => 'nullable|integer|min:1',
            'expires_at'       => 'nullable|date|after:today',
        ]);

        $validated['min_order_amount'] = $validated['min_order_amount'] ?? 0;
        $validated['code'] = strtoupper($validated['code']);

        PromoCode::create($validated);
        return back()->with('success', 'Promo code created!');
    }

    public function toggle(PromoCode $promoCode)
    {
        $promoCode->update(['is_active' => !$promoCode->is_active]);
        return back()->with('success', 'Promo code status updated.');
    }

    public function destroy(PromoCode $promoCode)
    {
        $promoCode->delete();
        return back()->with('success', 'Promo code deleted.');
    }
}
