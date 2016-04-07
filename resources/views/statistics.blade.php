@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
              @if (Auth::user())
                <div class="panel-heading">Statistics</div>

                <div class="panel-body">
                  {{-- Most Played --}}
                    @if ($stats->totalMatches == 0)
                      None yet! Enter a match first.
                    @else
                      <div class="row">
                        <div class="col-sm-4 text-center">
                          <label class="label label-primary">Played Most Matches</label>
                          <div id="most-played pie-chart"></div>
                        </div>
                        {{-- Average 10 Point Match Score --}}
                        <div class="col-sm-4 text-center">
                          <label class="label label-primary">Average 10 Point Match Score</label>
                          <div id="average-default-victory-point-score pie-chart"></div>
                        </div>
                        {{-- Total Victory Points --}}
                        <div class="col-sm-4 text-center">
                          <label class="label label-primary">Total Victory Points</label>
                          <div id="total-victory-points pie-chart"></div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-12 text-center">
                          <label class="label label-primary">Average Position Score Per Match Size</label>
                          <div id="area-chart"></div>
                        </div>
                      </div>
                    @endif
                </div>
              @else
                <div class="panel-heading">Welcome</div>

                <div class="panel-body">
                    Catanolog's Landing Page.
                </div>
              @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script type="text/javascript">

Morris.Donut({
  element: 'most-played pie-chart',
  data: [
    @foreach ($stats->mostPlayed as $mostPlayed)
      {label: "{{ $mostPlayed->Player_Most_Games }}", value: {{ $mostPlayed->Most_Games_Played }}},
    @endforeach
  ]
});
Morris.Donut({
  element: 'average-default-victory-point-score pie-chart',
  data: [
    {label: "Average Score", value: {{ round($stats->avgVP10, 2) }} },
  ]
});
Morris.Donut({
  element: 'total-victory-points pie-chart',
  data: [
    @foreach ($stats->mostVP as $mostVP)
      {label: "{{ $mostVP->Player_Most_Vp }}", value: {{ $mostVP->Most_Total_Vp }}},
    @endforeach
  ]
});

Morris.Bar({
  element: 'area-chart',
  data: [
    @foreach ($stats->avgScoreFor as $mainKey => $avgScore)
      { y: '{{ $mainKey }} Players',
      @foreach ($avgScore as $subKey => $score)
      {{ $subKey }}: '{{ $score }}',
      @endforeach
      },
    @endforeach
  ],
  behaveLikeLine: false,
  xkey: 'y',
  ykeys: ['1', '2', '3', '4', '5', '6'],
  labels: ['First Place', 'Second Place', 'Third Place', 'Fourth Place', 'Fifth Place', 'Sixth Place'],
  hideHover: 'auto'
});


</script>
@endsection
