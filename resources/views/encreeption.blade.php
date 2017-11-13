@extends('layouts.app')

@section('content')
	<form id="encreeption-form" method="POST" enctype="multipart/form-data">
		{{ csrf_field() }}
		<div class="row">
			<div class="col col-lg-4 col-md-5 col-sm-6 col-12">
				<div class="form-group">
					<span class="badge badge-info">Password protection</span>
			        <input type="password" name="password" placeholder="password ..." class="form-control" />
				</div>
				<div class="form-group">
					<span class="badge badge-info">Image file</span>
			        <input type="file" name="image" class="form-control" id="image-input" />

					<div class="rounded img-raised image-preview image-preview--hidden"></div>
				</div>
			</div>

			<div class="col">
				<textarea
					id="message-input"
					class="form-control"
					name="message"
					placeholder="type here your message"
					rows="5"
					disabled></textarea>

				<div class="input-counter">
					first, you must browser an image file
				</div>

				<div class="button-frame pull-right">
					<button class="btn btn-info button-frame__button">encreepting</button>
					<div class="cssload-spinner button-frame__loader"></div>
				</div>
			</div>
		</div>
	</form>
@endsection

@section('bodyendScript')
	<script src="assets/js/encreeption.js"></script>
@endsection
