@extends($layout ?? 'theme-db-brutalist::layouts.app')

@section('title', $translation->meta_title ?? $translation->title ?? __('Página'))
@section('meta_description', $translation->meta_description ?? '')

@section('content')
<x-cms::content-region theme="db-brutalist" class="gap-y-16 pb-16" :data-cms-edit-url="!empty($page) ? route('admin.pages.edit', $page->id) : false" data-cms-edit-label="Editar Página">
    @if(isset($renderedSections) && count($renderedSections) > 0)
        @foreach($renderedSections as $sectionHtml)
            {!! $sectionHtml !!}
        @endforeach
    @else
        <div class="max-w-4xl mx-auto py-24 text-center brutalist-card p-12">
            <h1 class="text-3xl font-black uppercase text-black mb-3">{{ $translation->title ?? __('Página') }}</h1>
            <p class="text-black font-mono text-sm">{{ __('Esta página aún no dispone de bloques asignados.') }}</p>
        </div>
    @endif
</x-cms::content-region>

<!-- Schema.org WebPage JSON-LD -->
@endsection
