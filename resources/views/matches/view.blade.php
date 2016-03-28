@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="col-sm-offset-2 col-sm-8">
      <div class="panel panel-default">
        <div class="panel-heading">
          {{ $player->name }}
        </div>

        <div class="panel-body">
          <!-- Display Validation Errors -->
          @include('common.errors')

          <div class="row">
            <div class="col-md-4">
              <div class="panel panel-default">
                <div class="panel-heading">Total Matches Played</div>
                <div class="panel-body">
                  {{ $player->scores->count() }}
                </div>
              </div>
            </div>

            <div class="col-md-4">
              <div class="panel panel-default">
                <div class="panel-heading">Average Player Score</div>
                <div class="panel-body">
                  {{ round($player->scores->avg('victory_points'), 0) }}
                </div>
              </div>
            </div>

            <div class="col-md-4">
              <div class="panel panel-default">
                <div class="panel-heading">Total Wins</div>
                <div class="panel-body">
                  {{ count($wins) }}
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="panel panel-default">
                <div class="panel-heading">Matches Played</div>
                <table class="table table-hover">
                  <tr>
                    <th>Match</th>
                    <th>Score</th>
                    <th>Victory Point Limit</th>
                  </tr>
                  @foreach($player->scores()->get() as $score)
                    <tr>
                      <td><a href="{{ route('match.view', ['id' => $score->match->id]) }}">Round {{ $score->match->id }}</a></td>
                      <td>{{ $score->victory_points }}</td>
                      <td>{{ $score->match->maximum_victory_points }}</td>
                    </tr>
                  @endforeach
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
