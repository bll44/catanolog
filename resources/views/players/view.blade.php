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

          @if ($scorecard)
            <div class="row">
              <div class="col-md-6">
                <div class="panel panel-default">
                  <div class="panel-heading">Total Matches Played</div>
                  <div class="panel-body">
                    {{ $player->scores->count() }}
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="panel panel-default">
                  <div class="panel-heading">Total Wins</div>
                  <div class="panel-body">
                    {{ count($player->wins) }}
                  </div>
                </div>
              </div>
            </div>

            @foreach ($scorecard as $value)
              <div class="row">
                @foreach ($value as $scorecard)

                  <div class="col-md-6">

                    <div class="panel panel-default">
                      <div class="panel-heading">
                        Average {{ $scorecard['match_size'] }} Player Match Score <br>
                        <small>
                          <span class="label label-default">
                            First To Obtain
                            @if ($scorecard['match_size'] == 3)
                              12
                            @else
                              10
                            @endif
                              Victory Points
                          </span>
                        </small>
                      </div>

                      <div class="panel-body">
                        @if (isset($scorecard['average_score']['whole']))
                          {{ $scorecard['average_score']['whole'] }}
                          <sup>{{ $scorecard['average_score']['numerator'] }}</sup>
                          /
                          <sub>{{ $scorecard['average_score']['denominator'] }}</sub>
                        @elseif ($scorecard['average_score'])
                          {{ $scorecard['average_score'] }}
                        @else
                          No Matches Found.
                        @endif
                      </div>
                    </div>

                  </div>

                @endforeach
              </div>
            @endforeach

            <div class="row">
              <div class="col-md-12">
                <div class="panel panel-default">
                  <div class="panel-heading">Matches Played</div>
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>Match</th>
                        <th>Score</th>
                        <th>Victory Point Limit</th>
                      </tr>
                    </thead>
                    @foreach($player->scores()->get() as $score)
                      <tr>
                        <td class="col-md-4"><a href="{{ route('match.view', ['id' => $score->match->id]) }}">Round {{ $score->match->id }}</a></td>
                        <td class="col-md-4">{{ $score->victory_points }}</td>
                        <td class="col-md-4">{{ $score->match->maximum_victory_points }}</td>
                      </tr>
                    @endforeach
                  </table>
                </div>
              </div>
            </div>
          @else
          {{ $player->name }} hasn't played yet!  Enter match details with their score to see this page.
          @endif
        </div>
      </div>
    </div>
  </div>
@endsection
