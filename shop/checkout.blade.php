@extends('theme-db-brutalist::layouts.app')

@section('title', __('shop::public.checkout_title'))

@section('content')
<div class="max-w-5xl mx-auto space-y-8 font-mono">
    <div class="space-y-2">
        <h1 class="text-3xl font-black uppercase text-black">{{ __('shop::public.checkout_title') }}</h1>
        <p class="text-xs font-bold text-black">{{ __('shop::public.checkout_description') }}</p>
    </div>
    <div class="brutalist-card p-6">
        @include('shop::partials.checkout-form', [
            'items' => $items,
            'subtotal' => $subtotal,
            'taxTotal' => $taxTotal,
            'grandTotal' => $grandTotal,
            'currentMarket' => $currentMarket,
            'currentLocale' => $currentLocale,
        ])
    </div>
</div>
@endsection
