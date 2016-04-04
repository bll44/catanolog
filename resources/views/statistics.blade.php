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
                    @if ($stats->totalMatches = 0)
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
                      {{-- <div class="row">
                        <div class="col-sm-12 text-center">
                          <label class="label label-primary">Bar stacked</label>
                          <div id="stacked"></div>
                        </div>
                      </div> --}}
                      {{-- <div class="panel panel-default">
                        <div class="panel-heading">Average Player Standings Score Per Match Type</div>
                        <table class="table">
                          <thead>
                            <tr>
                              <th># Of Players</th>
                              <th>First Place</th>
                              <th>Second Place</th>
                              <th>Third Place</th>
                              <th>Fourth Place</th>
                              <th>Fifth Place</th>
                              <th>Six Place</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <th scope="row">1</th>
                            </tr>
                          </tbody>
                        </table>
                      </div> --}}
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

new Morris.Donut({
  element: 'most-played pie-chart',
  data: [
    @foreach($stats->mostPlayed as $mostPlayed)
      {label: "{{ $mostPlayed->Player_Most_Games }}", value: {{ $mostPlayed->Most_Games_Played }}},
    @endforeach
  ]
});
new Morris.Donut({
  element: 'average-default-victory-point-score pie-chart',
  data: [
    {label: "Average Score", value: {{ round($stats->avgVP10, 2) }} },
  ]
});
new Morris.Donut({
  element: 'total-victory-points pie-chart',
  data: [
    @foreach($stats->mostVP as $mostVP)
      {label: "{{ $mostVP->Player_Most_Vp }}", value: {{ $mostVP->Most_Total_Vp }}},
    @endforeach
  ]
});

var data = [
      { y: '2014', a: 50, b: 90},
      { y: '2015', a: 65,  b: 75},
      { y: '2016', a: 50,  b: 50},
      { y: '2017', a: 75,  b: 60},
      { y: '2018', a: 80,  b: 65},
      { y: '2019', a: 90,  b: 70},
      { y: '2020', a: 100, b: 75},
      { y: '2021', a: 115, b: 75},
      { y: '2022', a: 120, b: 85},
      { y: '2023', a: 145, b: 85},
      { y: '2024', a: 160, b: 95}
    ],
    config = {
      data: data,
      xkey: 'y',
      ykeys: ['a', 'b'],
      labels: ['Total Income', 'Total Outcome'],
      fillOpacity: 0.6,
      hideHover: 'auto',
      behaveLikeLine: true,
      resize: true,
      pointFillColors:['#ffffff'],
      pointStrokeColors: ['black'],
      lineColors:['gray','red']
  };
config.element = 'stacked';
config.stacked = false;
Morris.Bar(config);


</script>
@endsection
