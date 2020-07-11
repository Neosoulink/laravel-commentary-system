@extends('layouts.app')

@section('content')
<div class="container">
    <div class="nav navbar-dark">
        <h2 class="display-4">Bienvenu dans le sytème de commentaire : </h2>
    </div>
    <form action="{{ route('page.get') }}" method="post">
        @csrf
        <div class="form-group">
            <label for="">Entrer la referance de votre page commentaire :</label>
            <input type="text" name="ref_page" class="form-control  @error('ref_page') is-invalid @enderror" placeholder="Ex: page1">
            @error('ref_page')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Accerder</button>
    </form>
</div>
@endsection
