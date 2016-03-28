@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
              @if (Auth::user())
                <div class="panel-heading">Statistics</div>

                <div class="panel-body">
                  {{-- <div id="myfirstchart" style="height: 250px;"></div> --}}
                  {{-- Most Played --}}
                  <div class="row">
                    <div class="col-sm-4 text-center">
                      <label class="label label-success">Played Most Matches</label>
                      <div id="most-played" style="min-height: 250px;"></div>
                    </div>

                    <div class="col-sm-4 text-center">
                      <label class="label label-success">Average 10 Point Match Score</label>
                      <div id="average-default-victory-point-score" style="min-height: 250px;"></div>
                    </div>
                    {{-- Total Victory Points --}}
                    <div class="col-sm-4 text-center">
                      <label class="label label-success">Total Victory Points</label>
                      <div id="total-victory-points" style="min-height: 250px;"></div>
                    </div>
                  </div>
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
  element: 'most-played',
  data: [
    @foreach($stats->mostPlayed as $mostPlayed)
    {label: "{{ $mostPlayed->Player_Most_Games }}", value: {{ $mostPlayed->Most_Games_Played }}},
    @endforeach
  ]
});
new Morris.Donut({
  element: 'average-default-victory-point-score',
  data: [
    {label: "Average Score", value: {{ round($stats->avgVP10, 2) }} },
  ]
});
new Morris.Donut({
  element: 'total-victory-points',
  data: [
    @foreach($stats->mostVP as $mostVP)
    {label: "{{ $mostVP->Player_Most_Vp }}", value: {{ $mostVP->Most_Total_Vp }}},
    @endforeach
  ]
});

new Morris.Line({
  // ID of the element in which to draw the chart.
  element: 'myfirstchart',
  // Chart data records -- each entry in this array corresponds to a point on
  // the chart.
  data: [
    { year: '2008', value: 20 },
    { year: '2009', value: 10 },
    { year: '2010', value: 5 },
    { year: '2011', value: 5 },
    { year: '2012', value: 20 }
  ],
  // The name of the data record attribute that contains x-values.
  xkey: 'year',
  // A list of names of data record attributes that contain y-values.
  ykeys: ['value'],
  // Labels for the ykeys -- will be displayed when you hover over the
  // chart.
  labels: ['Value']
});

</script>
@endsection
