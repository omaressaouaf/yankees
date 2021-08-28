@extends('layouts.app')
@section('title')
Nos Menus -
@endsection
@section('description')
Nous avons le meilleur menu de smashburger , Hot dogs , Submarine à casablanca. avec des extras tels que des milkshakes
et des sides délicieux
@endsection
@section('canonical')
https://yankees.ma/meals
@endsection
@section('content')
@include('includes.hero-meals' )

<article v-cloak>
    <meals-index />
</article>
<div>

</div>


@endsection
