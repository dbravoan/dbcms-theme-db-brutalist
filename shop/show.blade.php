@extends('theme-db-brutalist::layouts.app')

@section('title', ($translation->meta_title ?? $translation->name) . ' - dbCMS Brutalist')
@section('meta_description', $translation->meta_description ?? $translation->summary ?? '')

@section('content')
<div class="max-w-7xl mx-auto space-y-16 font-mono" x-data="{ activeImage: @js($product->featured_image ?? '') }">

    <!-- Breadcrumbs -->
    <nav class="flex items-center gap-2 text-xs text-black font-black uppercase">
        <a href="{{ route('shop.index', ['market' => $currentMarket->code, 'locale' => $currentLocale]) }}" class="hover:bg-[#FFE600] px-1">{{ __(__('Catálogo')) }}</a>
        <span>/</span>
        @if($product->category)
            <span>{{ $product->category->localizedName() }}</span>
            <span>/</span>
        @endif
        <span class="bg-[#00F0FF] px-1 border border-black">{{ $translation->name }}</span>
    </nav>

    <!-- Product Overview Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">

        <!-- Left: Image Gallery -->
        <div class="space-y-4">
            <div class="brutalist-card h-96 sm:h-[480px] bg-black overflow-hidden flex items-center justify-center p-4">
                <template x-if="activeImage">
                    <img :src="activeImage" alt="{{ $translation->name }}" class="max-h-full max-w-full object-contain" loading="lazy" decoding="async">
                </template>
                <template x-if="!activeImage">
                    <div class="text-[#FFE600] text-6xl font-black">[ PROD ]</div>
                </template>
            </div>

            <!-- Thumbnail Switcher -->
            @if(!empty($product->gallery_images) && count($product->gallery_images) > 0)
                <div class="flex items-center gap-3 overflow-x-auto pb-2">
                    @if($product->featured_image)
                        <button type="button" @click="activeImage = @js($product->featured_image)" class="w-16 h-16 rounded overflow-hidden border-2 bg-black shrink-0 transition-all" :class="activeImage === @js($product->featured_image) ? 'border-[#FFE600] shadow-[3px_3px_0px_0px_#000]' : 'border-black opacity-60 hover:opacity-100'">
                            <img src="{{ $product->featured_image }}" class="w-full h-full object-cover" loading="lazy" decoding="async">
                        </button>
                    @endif
                    @foreach($product->gallery_images as $gImg)
                        <button type="button" @click="activeImage = @js($gImg)" class="w-16 h-16 rounded overflow-hidden border-2 bg-black shrink-0 transition-all" :class="activeImage === @js($gImg) ? 'border-[#FFE600] shadow-[3px_3px_0px_0px_#000]' : 'border-black opacity-60 hover:opacity-100'">
                            <img src="{{ $gImg }}" class="w-full h-full object-cover" loading="lazy" decoding="async">
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Right: Specs, Pricing & Purchase / Quote Action Box -->
        <div class="brutalist-card p-6 sm:p-8 space-y-6">
            <div class="space-y-2 border-b-2 border-black pb-5">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-black uppercase bg-[#FFE600] px-2 py-0.5 border border-black">
                        {{ $product->category?->localizedName() ?? 'Hardware' }}
                    </span>
                    <span class="text-xs text-black font-black">
                        SKU: {{ $product->sku }}
                    </span>
                </div>
                <h1 class="text-2xl sm:text-4xl font-black text-black leading-tight uppercase">
                    {{ $translation->name }}
                </h1>
            </div>

            <!-- Short Summary -->
            <p class="text-black font-semibold text-sm leading-relaxed bg-[#FFE600]/20 p-3 border-2 border-black">
                {{ $translation->summary ?? 'Diseño técnico neo-brutalista de alto rendimiento y arquitectura robusta.' }}
            </p>

            <!-- Actions: Cart vs Quote -->
            @include('shop::partials.product-offer')

            <!-- Technical Specifications -->
            @include('shop::partials.product-specifications')

        </div>

    </div>

    <!-- Modular Sections & Detailed Description -->
    @if(isset($renderedSections) && count($renderedSections) > 0)
        <section class="space-y-12">
            <h2 class="text-2xl font-black text-black uppercase border-b-3 border-black pb-3">{{ __('DETALLES DEL PRODUCTO') }}</h2>
            @foreach($renderedSections as $sectionHtml)
                <div>
                    {!! $sectionHtml !!}
                </div>
            @endforeach
        </section>
    @elseif(!empty($translation->description))
        <section class="brutalist-card p-8 sm:p-10 text-black font-medium text-sm leading-relaxed max-w-none">
            {!! app(\DbCms\Core\Services\Media\MarkdownRendererService::class)->render((string) $translation->description) !!}
        </section>
    @endif

    <!-- Related Products -->
    @if($relatedProducts->isNotEmpty())
        <section class="space-y-6">
            <h2 class="text-2xl font-black text-black uppercase border-b-3 border-black pb-3">
                PRODUCTOS RELACIONADOS
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                @foreach($relatedProducts as $rel)
                    @php
                        $relTrans = public_translation($rel, $currentLocale, $currentMarket ?? null);
                        $shopPrefix = app(\DbCms\Core\Contracts\Services\LocalizationServiceInterface::class)->getModulePrefix('shop', $currentLocale) ?: 'shop';
                        $relUrl = app(\DbCms\Core\Contracts\Services\LocalizationServiceInterface::class)->url("/{$shopPrefix}/{$relTrans?->slug}", $currentMarket);
                    @endphp
                    <a href="{{ $relUrl }}" class="brutalist-card p-4 hover:bg-[#FFE600]/20 transition-all block space-y-3 group">
                        <div class="h-32 bg-black rounded overflow-hidden flex items-center justify-center">
                            @if($rel->featured_image)
                                <img src="{{ $rel->featured_image }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform" loading="lazy" decoding="async">
                            @else
                                <span class="text-3xl text-[#FFE600] font-black">[ PROD ]</span>
                            @endif
                        </div>
                        <h4 class="font-black text-black group-hover:text-[#FF5A5F] transition-colors truncate text-sm uppercase">{{ $relTrans?->name }}</h4>
                        @include('shop::partials.product-price', ['product' => $rel])
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    <!-- Inquiry Modal -->


</div>

@endsection
