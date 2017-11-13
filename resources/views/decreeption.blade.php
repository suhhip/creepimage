@extends('layouts.app')

@section('content')
	<form id="decreeption-form" action="/ajax/decreeption" method="POST" enctype="multipart/form-data">
		{{ csrf_field() }}
		<div class="row">
			<div class="col">
				<div class="form-group">
					<span class="badge badge-info">Image file</span>
			        <input type="file" name="image" class="form-control" id="image-input" />
				</div>
			</div>

			<div class="col">
				<div class="form-group">
					<span class="badge badge-info">Password protection</span>
			        <input type="password" name="password" placeholder="password ..." class="form-control" />
				</div>

				<div class="button-frame pull-right">
					<button class="btn btn-info button-frame__button">decreeping</button>
					<div class="cssload-spinner button-frame__loader"></div>
				</div>
			</div>
		</div>
	</form>

	<div id="encreepted-data" class="row">
		<div class="col">
			<span class="badge badge-info">Encreepted message</span>
			<div id="encreepted-data__text"></div>
		</div>
	</div>
@endsection

@section('bodyendScript')
	<script src="assets/js/decreeption.js"></script>
@endsection
