@extends('layout')

@section('content')

<h1> Városok listája 
    <a href="{{route('cities.create')}}" title="Új város">➕</a>
    <button type="button" class="button" data-action="show" title="Megjelenítés">👁️</button>
    <button type="button" class="button" data-action="edit" title="Szerkesztés">✏️</button>
    <button type="button" class="danger" data-action="delete" title="Törlés">🗑️</button>

    <a href="{{route('cities.index', ['sort_by' => 'city', 'sort_dir' => 'asc', 'search' => request('search'), 'county' => request('county')])}}" title="ABC">🔽</a>
    <a href="{{route('cities.index', ['sort_by' => 'city', 'sort_dir' => 'desc', 'search' => request('search'), 'county' => request('county')])}}" title="ZYX">🔼</a>
</h1>

<form id="quick-delete-form" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
</form>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<form action="{{ route('cities.index') }}" method="GET" class="search-form">
    <input type="text" name="search" value="{{ $search }}" placeholder="Város keresése...">

    <select name="county" onchange="this.form.submit()">
        <option value="">Összes megye</option>
        @foreach($counties as $county)
            <option value="{{ $county->id }}" {{ (string) $countyFilter === (string) $county->id ? 'selected' : '' }}>
                {{ $county->name }}
            </option>
        @endforeach
    </select>

    <button type="submit">🔍 Keresés</button>
    @if($search || $countyFilter)
        <a href="{{ route('cities.index') }}">✕ Törlés</a>
    @endif
</form>

<table class="table" data-quick-actions data-base-route="{{ url('/cities') }}">
    <thead>
        <tr>
            <th>ID</th>
            <th>Irányítószám</th>
            <th>Város</th>
            <th>Megye</th>
            <th>Lakosság</th>
            <!--<th>Műveletek</th>-->
        </tr>
    </thead>
    <tbody>
        @foreach($cities as $city)
            <tr data-id="{{ $city->id }}">
                <td>{{ $city->id }}</td>
                <td>{{ $city->zip_code }}</td>
                <td>{{ $city->city }}</td>
                <td>{{ $city->county?->name ?? 'Ismeretlen megye' }}</td>
                <td>{{ $city->population }}</td>
                <!--<td class="spec-row-actions">
                    <div class="actions-inner">
                        <a href="{{ route('cities.show', $city->id) }}" class="button">Megjelenítés</a>
                        <a href="{{ route('cities.edit', $city->id) }}" class="button">Szerkesztés</a>
                        <form action="{{ route('cities.destroy', $city->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="danger" onclick="return confirm('Biztosan törlöd?')">Törlés</button>
                        </form>
                    </div>
                </td>-->
            </tr>
        @endforeach
    </tbody>
</table>


<div id="paginator">
    <!--{{ $cities->appends(['sort_by' => request('sort_by'), 'sort_dir' => request('sort_dir')])->links() }}-->
    {{ $cities->appends(['sort_by' => request('sort_by'), 'sort_dir' => request('sort_dir'), 'search' => request('search'), 'county' => request('county')])->links() }}

</div>

@endsection