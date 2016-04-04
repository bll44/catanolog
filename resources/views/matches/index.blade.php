@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="col-sm-offset-2 col-sm-8">
      <div class="panel panel-default">
        <div class="panel-heading">
          New Match
        </div>

        <div class="panel-body">
          <!-- Display Validation Errors -->
          @include('common.errors')

          <!-- New Match Form -->
          <form action="{{ route('match.add') }}" method="POST" class="form-horizontal">
            {{ csrf_field() }}

            <!-- Maximum Victory Point -->
            <div class="form-group">
              <label for="maximum_victory_points" min="1" class="col-sm-3 control-label">Maximum Victory Points</label>

              <div class="col-sm-6">
                <input type="number" name="maximum_victory_points" id="maximum_victory_points" min="0" class="form-control" value="{{ old('maximum_victory_points') }}">
              </div>
            </div>

            <!-- Players -->
            <div class="form-group">
              <label for="total_players" class="col-sm-3 control-label">Total Players</label>

              <div class="col-sm-6">
                <input type="number" name="total_players" id="total_players" min="3" max="6" class="form-control" value="{{ old('total_players') }}">
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

      <!-- Current Matches -->
      @if (count($matches) > 0)
        <div class="panel panel-default">
          <div class="panel-heading">
            Matches
          </div>

          <div class="panel-body">
            <table class="table table-striped match-table">
              <thead>
                <th>Match</th>
                <th>&nbsp;</th>
              </thead>
              <tbody>
                @foreach ($matches as $match)
                  <tr>
                    <td class="table-text">
                      <div>
                        <a href="{{ route('match.view', ['id' => $match->id]) }}">Match {{ $match->id }}</a>
                      </div>
                    </td>

                    <!-- Match Delete Button -->
                    <td class="text-right">
                      <form action="/match/{{ $match->id }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}

                        <button type="submit" id="delete-match-{{ $match->id }}" class="btn btn-danger">
                          <i class="fa fa-btn fa-trash"></i>Delete
                        </button>
                      </form>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          {!! $matches->links() !!}
        </div>
      @endif
    </div>
  </div>
@endsection
