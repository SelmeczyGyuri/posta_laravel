@extends('layout')

@section('content')

<div class="spec-back-link">
    <a href="{{ route('counties.index') }}" class="btn btn-secondary">← Vissza a listához</a>
</div>

<h1>{{ $county->name }} szerkesztése</h1>

@error('name')
<div class="alert alert-warning">
    {{ $message }}
</div>
@enderror

@error('crest_url')
<div class="alert alert-warning">
    {{ $message }}
</div>
@enderror

<form action="{{ route('counties.update', $county->id) }}" method="POST">
    @csrf
    @method('PUT')
    <fieldset>
    <legend>Megye adatai</legend>
    <label for="name">Megye neve:</label>
    <input type="text" name="name" id="name" value="{{ old('name', $county->name) }}">
    <br>
    <label for="crest_url">Címere:</label>
    <input type="text" name="crest_url" id="crest_url" value="{{ old('crest_url', $county->crest_url) }}">
    <br>
    <button type="submit">Mentés</button>
</fieldset>
</form>
@endsection