@extends('layout')

@section('content')

<div class="spec-back-link">
    <a href="{{ route('cities.index') }}" class="btn btn-secondary">← Vissza a listához</a>
</div>

<h1> Város szerkesztése </h1>

@error('zip_code')
<div class="alert alert-warning">
    {{ $message }}
</div>
@enderror

@error('city')
<div class="alert alert-warning">
    {{ $message }}
</div>
@enderror

@error('id_county')
<div class="alert alert-warning">
    {{ $message }}
</div>
@enderror

@error('population')
<div class="alert alert-warning">
    {{ $message }}
</div>
@enderror

<form action="{{ route('cities.update', $city->id) }}" method="POST">
    @csrf
    @method('PUT')
    <fieldset>
    <legend>Város adatai</legend>
    <label for="zip_code">Irányítószám:</label>
    <input type="number" name="zip_code" id="zip_code" value="{{ old('zip_code', $city->zip_code) }}">
    <br>
    <label for="city">Város:</label>
    <input type="text" name="city" id="city" value="{{ old('city', $city->city) }}">
    <br>
    <label for="id_county">Megye:</label>
    <select name="id_county" id="id_county">
        <option value="">— Válassz megyét —</option>
        @foreach($counties as $county)
            <option value="{{ $county->id }}"
                {{ old('id_county', $city->id_county) == $county->id ? 'selected' : '' }}>
                {{ $county->name }}
            </option>
        @endforeach
    </select>
    <br>
    <label for="population">Népesség:</label>
    <input type="number" name="population" id="population" value="{{ old('population', $city->population) }}">
    <br>
    <button type="submit">Mentés</button>
</fieldset>
</form>
@endsection