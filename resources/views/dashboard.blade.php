@extends('layouts/master')

@section('content')

@javascript(compact('pusherKey', 'pusherCluster', 'usingNodeServer'))

<dashboard id="dashboard" columns="5" rows="3">
    <twitter :initial-tweets="{{ json_encode($initialTweets) }}" position="a1:a3"></twitter>
    <packagist position="b1"></packagist>
    <npm position="b2"></npm>
    <github position="b3"></github>
    <socks position="d1" :initial-sock-count="{{ $initialSockCount }}"></socks>
    <instagram :initial-photos="{{ json_encode($initialInstagramPhotos) }}" position="c1:c3"></instagram>
    <time-weather position="e1" date-format="ddd DD/MM" time-zone="Europe/Brussels" weather-city="Amsterdam"></time-weather>
    <calendar position="d2:e3"></calendar>
    <internet-connection></internet-connection>
</dashboard>

@endsection
