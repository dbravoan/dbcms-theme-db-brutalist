@extends('theme-db-brutalist::layouts.app')

@section('title', __('shop::public.cart_title') . ' - dbCMS Brutalist')

@section('content')
<div class="max-w-5xl mx-auto space-y-8 font-mono">

    <div class="flex items-center justify-between border-b-3 border-black pb-4">
        <div>
            <h1 class="text-3xl sm:text-4xl font-black text-black uppercase">
                {{ __('shop::public.cart_title') }}
            </h1>
            <p class="text-xs text-black font-bold mt-1">{{ __('shop::public.cart_subtitle') }}</p>
        </div>
        <a href="{{ route('shop.index', ['market' => $currentMarket->code, 'locale' => $currentLocale]) }}" class="btn-brutalist px-3 py-1 text-xs">
            &larr; {{ __('shop::public.continue_shopping') }}
        </a>
    </div>

    @if(empty($items))
        <div class="p-16 text-center brutalist-card space-y-4">
            <span class="text-5xl block text-black"><i class="fa-solid fa-cart-shopping"></i></span>
            <h3 class="text-xl font-black uppercase text-black">{{ __('shop::public.empty_cart') }}</h3>
            <a href="{{ route('shop.index', ['market' => $currentMarket->code, 'locale' => $currentLocale]) }}" class="btn-brutalist text-xs inline-block px-5 py-2.5">{{ __('shop::public.explore_shop') }} &rarr;</a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 brutalist-card overflow-hidden">
                @include('shop::partials.cart-items', [
                    'items' => $items,
                    'currentMarket' => $currentMarket,
                    'currentLocale' => $currentLocale,
                ])
            </div>
            <div class="brutalist-card p-6 space-y-4 h-fit">
                @include('shop::partials.cart-summary', [
                    'subtotal' => $subtotal,
                    'taxTotal' => $taxTotal,
                    'grandTotal' => $grandTotal,
                    'currentMarket' => $currentMarket,
                    'currentLocale' => $currentLocale,
                ])
            </div>
        </div>
    @endif

</div>
@endsection
