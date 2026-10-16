@extends('layouts.app')

@section('title', $notice->title)

@section('content')
<div class="container py-5">
    <div class="row g-4">
        {{-- Main Notice --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 p-lg-5">

                    {{-- Header --}}
                    <div class="mb-4">
                        @if(strtolower($notice->priority) === 'urgent')
                            <span class="badge bg-danger mb-2">
                                <i class="bi bi-exclamation-circle"></i> Urgent
                            </span>
                        @endif

                        <h1 class="h3 fw-bold mb-3">{{ $notice->title }}</h1>

                        <div class="d-flex flex-wrap gap-3 text-muted small">
                            <span>
                                <i class="bi bi-tag"></i>
                                {{ \App\Models\Notice::CATEGORIES[$notice->category] ?? ucfirst($notice->category) }}
                            </span>
                            <span>
                                <i class="bi bi-calendar"></i>
                                {{ $notice->published_at?->format('d M Y, h:i A') }}
                            </span>
                            @if($notice->author)
                                <span>
                                    <i class="bi bi-person"></i>
                                    {{ $notice->author->name }}
                                </span>
                            @endif
                            @if($notice->target_semester)
                                <span>
                                    <i class="bi bi-mortarboard"></i>
                                    {{ $notice->target_semester }}
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Body --}}
                    <div class="notice-content mb-4" style="line-height: 1.8;">
                        {!! nl2br(e($notice->description)) !!}
                    </div>

                    {{-- Attachment --}}
                    @if($notice->attachment_path)
                        <div class="border-top pt-4 mt-4">
                            <h6 class="fw-bold mb-2">
                                <i class="bi bi-paperclip"></i> Attachment
                            </h6>
                            <a href="{{ route('notices.download', $notice->id) }}"
                               class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-download"></i> Download File
                            </a>
                        </div>
                    @endif

                </div>
            </div>

            <a href="{{ route('home') }}" class="btn btn-link mt-3 ps-0">
                <i class="bi bi-arrow-left"></i> Back to Notice Board
            </a>
        </div>

        {{-- Sidebar: Related Notices --}}
        <div class="col-lg-4">
            @if($related->count())
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h6 class="fw-bold mb-0">
                            <i class="bi bi-list-ul"></i> Related Notices
                        </h6>
                    </div>
                    <ul class="list-group list-group-flush">
                        @foreach($related as $item)
                            <li class="list-group-item py-3">
                                <a href="{{ route('notices.show', $item->id) }}"
                                   class="text-decoration-none text-dark fw-medium d-block">
                                    {{ Str::limit($item->title, 60) }}
                                </a>
                                <div class="small text-muted mt-1">
                                    <i class="bi bi-calendar"></i>
                                    {{ $item->published_at?->format('d M Y') }}
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection