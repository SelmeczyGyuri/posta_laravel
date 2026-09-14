@extends('layout')

@section('content')

<h1>Megyék
    <a href="{{route('counties.create')}}" title="Új megye">➕</a>
    <button type="button" class="button" data-action="show" title="Megjelenítés">👁️</button>
    <button type="button" class="button" data-action="edit" title="Szerkesztés">✏️</button>
    <button type="button" class="danger" data-action="delete" title="Törlés">🗑️</button>
    
    <a href="{{route('counties.index', ['sort_by' => 'name', 'sort_dir' => 'asc', 'search' => request('search')])}}" title="ABC">🔽</a>
    <a href="{{route('counties.index', ['sort_by' => 'name', 'sort_dir' => 'desc', 'search' => request('search')])}}" title="ZYX">🔼</a>
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

<form action="{{ route('counties.index') }}" method="GET" class="search-form">
    <input type="text" name="search" value="{{ $search }}" placeholder="Megye keresése...">
    <button type="submit">🔍 Keresés</button>
    @if($search)
        <a href="{{ route('counties.index') }}">✕ Törlés</a>
    @endif
</form>

<table class="table" data-quick-actions data-base-route="{{ url('/counties') }}">
    <thead>
        <tr>
            <th>ID</th>
            <th>Megye</th>
            <th>Címer</th>
            <!--<th>Műveletek</th>-->
        </tr>
    </thead>
    <tbody>
        @foreach($counties as $county)
            <tr data-id="{{ $county->id }}">
                <td>{{ $county->id }}</td>
                <td>{{ $county->name }}</td>
                <td><img src="{{ $county->crest_url }}" alt="{{ $county->name }}" class="county-img"></td>
                <!--<td class="spec-row-actions">
                    <div class="actions-inner">
                        <a href="{{ route('counties.show', $county->id) }}" class="button">Megjelenítés</a>
                        <a href="{{ route('counties.edit', $county->id) }}" class="button">Szerkesztés</a>
                        <form action="{{ route('counties.destroy', $county->id) }}" method="POST">
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

@endsection
