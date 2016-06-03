@extends('layouts.app')

@section('content')
<div class="container">
  <div class="col-sm-offset-2 col-sm-8">
    <div class="panel panel-default">
      <div class="panel-heading">
        Match Details
      </div>

      <div class="panel-body">
        <!-- Display Validation Errors -->
        @include('common.errors')

        <!-- Match Details Form -->
        <form action="{{ route('match.details') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
          {{ csrf_field() }}

          <input type="hidden" name="maximum_victory_points" value="{{ $request->maximum_victory_points }}">
          <input type="hidden" name="total_players" value="{{ $request->total_players }}">

          <!-- Player Details -->
          @for ($i = 1; $i < $request->total_players + 1; $i++)
          <div class="panel panel-default">
            <div class="panel-heading">
              Player {{ $i }}
            </div>
            <div class="panel-body">
              <div class="form-group">
                <label for="player_name" class="col-sm-3 control-label">Name</label>
                <div class="col-sm-6">
                  <select class="form-control player-select" id="player_number_{{ $i }}" name="player[]"
                            data-toggle="popover" data-popover="popover-{{ $i }}">
                  <option disabled selected>Select Player...</option>
                  <option value="new-player">Add New Player</option>
                  <option disabled>--------------------</option>
                  <option>Cancel</option>
                  @foreach ($players as $player)r
                  <option value="{{ $player->id }}">{{ $player->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="player_score" class="col-sm-3 control-label">Score</label>
              <div class="col-sm-6">
                <input type="number" name="player_score[]" id="player_score" min="0" max="{{ $request->maximum_victory_points+1 }}" class="form-control" value="{{ old('player_score') }}" required>
              </div>
            </div>
          </div>
        </div>
        @endfor
        <div class="panel panel-default">
            <div class="panel-heading">
              Upload Match Photo
            </div>
            <div class="panel-body">
            	<div class="form-group">
            		<label for="match_photo" class="control-label"></label>
            		<div class="col-sm-9">
	            		<input type="file" name="match_photo" id="match_photo_file_input" class="form-control">
            		</div>
            	</div>
          </div>
        </div>
        <!-- Add Match Button -->
        <div class="form-group">
          <div class="col-sm-offset-3 col-sm-6">
            <button type="submit" class="btn btn-default">
              <i class="fa fa-btn fa-plus"></i>Add Match
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
</div>

<button id="test-pop" class="btn btn-danger btn-lg" type="button">Test</button>

@endsection

@section('javascript')
<script type="text/javascript">
var visiblePopover;

  $('select').change(function() {
    visiblePopover = $(this);
    if($(this).val() === 'new-player') $(this).popover('show');

  });

  $('#test-pop').click(function() {
    visiblePopover.popover('hide');
  });

  $(function() {
    visiblePopover = $('select').popover({
      content: '<input type="text" class="form-control" placeholder="Enter Player Name"><button type="button"  class="btn btn-primary">Add</button>',
      title: 'Add New Player',
      placement: 'right',
      trigger: 'manual',
      html: true,
      container: 'body'
    });
  });

  $(function() {
    console.log(visiblePopover);
  });

  $("select").change(function () {
  // stop execution of this script if criteria is met
  // i.e. new player add
  if($(this).val() === 'null' || $(this).val() === 'new-player') return;

  var $this = $(this);
  var prevVal = $this.data("prev");
  var otherSelects = $("select").not(this);

  otherSelects.find("option[value=" + $(this).val() + "]").attr('disabled', true);

  if (prevVal) {
    otherSelects.find("option[value=" + prevVal + "]").attr('disabled', false);
  }

  $this.data("prev", $this.val());
});

</script>
@endsection
