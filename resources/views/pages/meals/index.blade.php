@extends('layouts.app')
@section('content')
    @include('includes.hero-meals')
    <main id="main" v-cloak>
        <meals-index/>
    </main>


@endsection
