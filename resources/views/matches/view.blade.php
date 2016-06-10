@extends('layouts.app')

@section('content')
<div class="container">
	<div class="col-sm-offset-2 col-sm-8">
		<div class="panel panel-default">
			<div class="panel-heading">
				Match {{ $match->id }}
			</div>

			<div class="panel-body">
				<!-- Display Validation Errors -->
				@include('common.errors')

				<div class="row">

					<div class="col-md-4">
						<div class="panel panel-default">
							<div class="panel-heading">Victory Points Needed</div>
							<div class="panel-body">
								{{ $match->maximum_victory_points }}
							</div>
						</div>
					</div>

					<div class="col-md-4">
						<div class="panel panel-default">
							<div class="panel-heading">Average Player Score</div>
							<div class="panel-body">
								{{ round($match->scores->avg('victory_points'), 0) }}
							</div>
						</div>
					</div>

					<div class="col-md-4">
						<div class="panel panel-default">
							<div class="panel-heading">Winner</div>
							<div class="panel-body">
								{{ $match->scores->first()->player->name }}
							</div>
						</div>
					</div>

				</div><!-- /.row -->

				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-default">
							<div class="panel-heading">Match Players</div>
							<table class="table table-hover">
								<tr>
									<th>Players</th>
									<th>Color</th>
									<th>Score</th>
								</tr>
								@foreach ($match->scores as $score)
								<tr>
									<td class="col-md-4">
										<a href="{{ route('player.view', ['name' => $score->player->name]) }}">{{ $score->player->name }}</a>
									</td>
									<td class="col-md-4">{{ ucwords($score->color) }}</td>
									<td class="col-md-4">{{ $score->victory_points }}</td>
								</tr>
								@endforeach
							</table>
						</div>
					</div>
				</div><!-- /.row -->

				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-default">
							<span class="pull-right"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></span>
							<div class="panel-body">
								<div class="media">
									<div class="media-left">
										<a href="{{ $match->photo->url }}">
											<img class="media-object" src="{{ $match->photo->url }}" alt="Match {{ $match->id }} Photo" width="64" height="64">
										</a>
									</div>
									<div class="media-body">
										<h4 class="media-heading">Match {{ $match->id }} Photo</h4>
										Click to view a picture of the final board
									</div>
								</div>
							</div><!-- /.panel-body -->
						</div>
					</div><!-- /.column -->
				</div><!-- /.row -->

			</div>
		</div>
	</div>
</div>
@endsection
