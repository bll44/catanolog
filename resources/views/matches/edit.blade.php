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

				<form action="/match/update_photo" method="post" class="form-horizontal" enctype="multipart/form-data">
					{{ csrf_field() }}
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-default">
							<div class="panel-body">
								<div class="media">
									<div class="media-left">
										<a href="{{ $match->photo->url }}">
											<img class="media-object" src="{{ $match->photo->url }}?{{ rand() }}" alt="Match {{ $match->id }} Photo" width="64" height="64">
										</a>
									</div>
									<div class="media-body">
										<h4 class="media-heading">Match {{ $match->id }} Photo</h4>
										Click to view a picture of the final board
										<h4>Upload New Photo</h4>
										<input type="hidden" name="match_id" value="{{ $match->id }}">
										<input type="hidden" name="is_update" value="true">
										<input type="file" name="match_photo" class="form-control">
									</div><!-- /.media-body -->
								</div><!-- /.media -->
							</div><!-- /.panel-body -->
						</div><!-- /.column -->
					</div><!-- /.row -->
				</div><!-- /.row -->

				<div class="col-md-12">
					<div class="form-group">
						<button type="submit" class="btn btn-primary pull-right">Save Changes</button>
					</div>
				</div><!-- /.column -->

				</form><!-- /.updatePhoto form -->

			</div><!-- /.panel-body -->
		</div><!-- /.panel -->
	</div><!-- /.column -->
</div><!-- /.container -->

@endsection