@extends('layout')

@section('content')

<div class="spec-back-link">
    <a href="{{ route('counties.index') }}" class="btn btn-secondary">← Vissza a listához</a>
</div>

<div class="spec-layout">

    {{-- LEFT COLUMN: crest + county info + actions --}}
    <aside class="spec-aside">

        <div class="spec-img-wrap">
            @if($county->crest_url)
                <img src="{{ $county->crest_url }}"
                     alt="{{ $county->name }}"
                     class="spec-img"
                     onerror="this.style.display='none'; document.getElementById('spec-img-fallback').style.display='flex';">
            @endif
            <div id="spec-img-fallback" class="spec-img-fallback" style="{{ $county->crest_url ? 'display:none' : 'display:flex' }}">
                🛡️
            </div>
        </div>

        <div class="spec-header">
            <h1 class="spec-title">
                <span class="title-bar" aria-hidden="true"></span>
                {{ $county->name }}
            </h1>
        </div>

        <dl class="spec-table">
            <div class="spec-row">
                <dt class="spec-label">Összlakosság</dt>
                <dd class="spec-value spec-value--highlight">
                    {{ number_format($county->cities->sum('population'), 0, ',', ' ') }} fő
                </dd>
            </div>
            <div class="spec-row">
                <dt class="spec-label">Települések száma</dt>
                <dd class="spec-value">{{ $county->cities->count() }}</dd>
            </div>
        </dl>

        <div class="spec-aside-actions">
            <a href="{{ route('counties.edit', $county->id) }}" class="btn btn-primary spec-btn-full">✏️ Szerkesztés</a>
            <form action="{{ route('counties.destroy', $county->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger spec-btn-full"
                    onclick="return confirm('Biztosan törölni szeretnéd: {{ addslashes($county->name) }}? Ez törli a hozzá tartozó városokat is!')">
                    🗑️ Törlés
                </button>
            </form>
        </div>

    </aside>

    {{-- RIGHT COLUMN: cities belonging to this county --}}
    <div class="spec-main">

        <div class="spec-header">
            <h2 class="spec-title">
                <span class="title-bar" aria-hidden="true"></span>
                Települések
            </h2>
        </div>

        <div class="spec-divider" aria-hidden="true">
            <a href="{{ route('counties.show', ['county' => $county->id, 'sort_by' => 'city', 'sort_dir' => 'asc']) }}" title="ABC">🔽</a>
            <a href="{{ route('counties.show', ['county' => $county->id, 'sort_by' => 'city', 'sort_dir' => 'desc']) }}" title="ZYX">🔼</a>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Irányítószám</th>
                    <th>Település</th>
                    <th>Lakosság</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($cities as $city)
                    <tr>
                        <td>{{ $city->zip_code }}</td>
                        <td>{{ $city->city }}</td>
                        <td>{{ number_format($city->population, 0, ',', ' ') }}</td>
                        <td class="spec-row-actions">
                            <a href="{{ route('cities.show', $city->id) }}" class="btn btn-sm btn-secondary" title="Megtekintés">👁️</a>
                            <a href="{{ route('cities.edit', $city->id) }}" class="btn btn-sm btn-primary" title="Szerkesztés">✏️</a>
                            <form action="{{ route('cities.destroy', $city->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Törlés"
                                    onclick="return confirm('Biztosan törölni szeretnéd: {{ addslashes($city->city) }}?')">
                                    🗑️
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">Nincs település ehhez a megyéhez.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div id="paginator">
            {{ $cities->appends(['sort_by' => request('sort_by'), 'sort_dir' => request('sort_dir')])->links() }}
        </div>

    </div>

</div>

@endsection