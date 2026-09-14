@extends('layout')

@section('content')

<div class="spec-back-link">
    <a href="{{ route('cities.index') }}" class="btn btn-secondary">← Vissza a listához</a>
</div>

<div class="spec-layout">

    {{-- LEFT COLUMN: parent county's crest + link back --}}
    <aside class="spec-aside">

        <div class="spec-img-wrap">
            @if($city->county?->crest_url)
                <img src="{{ $city->county->crest_url }}"
                     alt="{{ $city->county->name }}"
                     class="spec-img"
                     onerror="this.style.display='none'; document.getElementById('spec-img-fallback').style.display='flex';">
            @endif
            <div id="spec-img-fallback" class="spec-img-fallback" style="{{ $city->county?->crest_url ? 'display:none' : 'display:flex' }}">
                🛡️
            </div>
        </div>

        <div class="spec-header">
            <h2 class="spec-title">
                <span class="title-bar" aria-hidden="true"></span>
                {{ $city->county?->name ?? 'Ismeretlen megye' }}
            </h2>
        </div>

        @if($city->county)
            <a href="{{ route('counties.show', $city->county->id) }}" class="btn btn-secondary spec-btn-full">
                📍 Megye megtekintése
            </a>
        @endif

        <div class="spec-aside-actions">
            <a href="{{ route('cities.edit', $city->id) }}" class="btn btn-primary spec-btn-full">✏️ Szerkesztés</a>
            <form action="{{ route('cities.destroy', $city->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger spec-btn-full"
                    onclick="return confirm('Biztosan törölni szeretnéd: {{ addslashes($city->city) }}?')">
                    🗑️ Törlés
                </button>
            </form>
        </div>

    </aside>

    {{-- RIGHT COLUMN: city details --}}
    <div class="spec-main">

        <div class="spec-header">
            <h1 class="spec-title">
                <span class="title-bar" aria-hidden="true"></span>
                {{ $city->city }}
            </h1>
        </div>

        <div class="spec-divider" aria-hidden="true">
            <span class="spec-divider-flag">📍</span>
        </div>

        <dl class="spec-table">
            <div class="spec-row">
                <dt class="spec-label">Irányítószám</dt>
                <dd class="spec-value">{{ $city->zip_code }}</dd>
            </div>
            <div class="spec-row">
                <dt class="spec-label">Megye</dt>
                <dd class="spec-value">{{ $city->county?->name ?? 'Ismeretlen megye' }}</dd>
            </div>
            <div class="spec-row">
                <dt class="spec-label">Lakosság</dt>
                <dd class="spec-value spec-value--highlight">
                    {{ number_format($city->population, 0, ',', ' ') }} fő
                </dd>
            </div>
        </dl>

    </div>

</div>

@endsection