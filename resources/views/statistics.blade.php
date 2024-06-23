@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Team Statistics: {{ $team->name }}</h1>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>Overall Statistics</h3>
                </div>
                <div class="card-body">
                    <ul>
                        <li>Total Kills: {{ $teamStatistics['total_kills'] }}</li>
                        <li>Total Damage Dealt: {{ $teamStatistics['total_damage'] }}</li>
                        <li>Total Survival Time: {{ gmdate('H:i:s', $teamStatistics['total_survival_time']) }}</li>
                        <li>Total Assists: {{ $teamStatistics['total_assists'] }}</li>
                        <li>Total Heals: {{ $teamStatistics['total_heals'] }}</li>
                        <li>Total Walk Distance: {{ $teamStatistics['total_walk_distance'] }}</li>
                        <li>Total Ride Distance: {{ $teamStatistics['total_ride_distance'] }}</li>
                    </ul>
                    <div class="share-buttons">
                        <div class="sharethis-inline-share-buttons"
                         data-url="{{ url()->current() }}#team-statistics"
                         data-title="Overall Statistics: {{ $team->name }}"></div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

    <div class="row flex-wrap">
        @foreach ($playerStatistics as $playerName => $stats)
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3>{{ $playerName }}</h3>
                </div>
                <div class="card-body">
                    <ul>
                        <li>Kills: {{ $stats['kills'] }}</li>
                        <li>Damage Dealt: {{ $stats['damageDealt'] }}</li>
                        <li>Survival Time: {{ gmdate('H:i:s', $stats['timeSurvived']) }}</li>
                        <li>Assists: {{ $stats['assists'] }}</li>
                        <li>Heals: {{ $stats['heals'] }}</li>
                        <li>Walk Distance: {{ $stats['walkDistance'] }}</li>
                        <li>Ride Distance: {{ $stats['rideDistance'] }}</li>
                    </ul>
                    <div class="share-buttons">
                        <div class="sharethis-inline-share-buttons"
                         data-url="{{ url()->current() }}#player-{{ $loop->index }}"
                         data-title="Player statistics: {{ $playerName }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
<script type="text/javascript" src="https://platform-api.sharethis.com/js/sharethis.js#property=667865119749f30019d767f3&product=inline-share-buttons&source=platform" async="async"></script>
@endsection
