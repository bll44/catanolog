@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="col-sm-offset-2 col-sm-8">
      <div class="panel panel-default">
        <div class="panel-heading">
          New Player
        </div>

        <div class="panel-body">
          <!-- Display Validation Errors -->
          @include('common.errors')

          <!-- New Player Form -->
          <form action="{{ route('player.add') }}" method="POST" class="form-horizontal">
            {{ csrf_field() }}

            <!-- Player Name -->
            <div class="form-group">
              <label for="player-name" class="col-sm-3 control-label">Player</label>

              <div class="col-sm-6">
                <input type="text" name="name" id="player-name" class="form-control" value="{{ old('player') }}" autofocus="true">
              </div>
            </div>

            <!-- Add Player Button -->
            <div class="form-group">
              <div class="col-sm-offset-3 col-sm-6">
                <button type="submit" class="btn btn-default">
                  <i class="fa fa-btn fa-plus"></i>Add Player
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>

      <!-- Current Players -->
      @if (count($players) > 0)
        <div class="panel panel-default">
          <div class="panel-heading">
            Players
          </div>

          <div class="panel-body">
            <table class="table table-striped player-table">
              <thead>
                <th>Player</th>
                <th>&nbsp;</th>
              </thead>
              <tbody>
                @foreach ($players as $player)
                  <tr>
                    <td class="table-text">
                      <div>
                        <a href="{{ route('player.view', ['name' => $player->name]) }}">{{ $player->name }}</a>
                      </div>
                    </td>

                    <!-- Player Delete Button -->
                    <td class="text-right">
                      <form action="/player/{{ $player->id }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}

                        <button type="submit" id="delete-player-{{ $player->id }}" class="btn btn-danger">
                          <i class="fa fa-btn fa-trash"></i>Delete
                        </button>
                      </form>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          {!! $players->links() !!}
        </div>
      @endif
    </div>
  </div>
@endsection
