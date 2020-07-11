@extends('layouts.app')

@section('content')
    <div id="app">
        <header class="text-center shadow-sm w-100 bg-light" >
            <h2 class="display-4 pb-3 text-muted">{{ $title ?? 'Page inconue !' }}</h2>
        </header>
        <div class="container flex pt-4">
            <Comments :current-user="{{ $currentUser }}"></Comments>
        </div>
    </div>
@endsection
