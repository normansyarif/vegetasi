<!DOCTYPE html>
<html>
<head>
	<title>Laravel</title>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<style type="text/css">
		@import url(https://fonts.googleapis.com/css?family=Roboto:400,400italic,600,600italic,700,700italic);
		body {
			font-family: 'Roboto';
			background-color: #f9f9f9;
		}

		.container1{
			padding:0;
			margin:10px;
			border-radius:5px;
			box-shadow: 0 2px 3px rgba(0,0,0,.3);
			background: white;

		}

		header {
			position: relative;
		}

		.hide {
			display: none;
		}

		.tab-content {
			padding:25px;
		}

		#material-tabs {
			position: relative;
			display: block;
			padding:0;
			border-bottom: 1px solid #e0e0e0;
		}

		#material-tabs>a {
			position: relative;
			display:inline-block;
			text-decoration: none;
			padding: 22px;
			text-transform: uppercase;
			font-size: 14px;
			font-weight: 600;
			color: #424f5a;
			text-align: center;
			width: 170px;
		}

		#material-tabs>a.active {
			font-weight: 700;
			outline:none;
		}

		#material-tabs>a:not(.active):hover {
			background-color: inherit;
			color: #7c848a;
		}

		@media only screen and (max-width: 520px) {
			.nav-tabs#material-tabs>li>a {
				font-size: 11px;
			}
		}

		.yellow-bar {
			position: absolute;
			z-index: 10;
			bottom: 0;
			height: 3px;
			background: #458CFF;
			display: block;
			left: 0;
			transition: left .2s ease;
			-webkit-transition: left .2s ease;
		}

		#tab1-tab.active ~ span.yellow-bar {
			left: 0;
			width: 170px;
		}

		#tab2-tab.active ~ span.yellow-bar {
			left:170px;
			width: 170px;
		}
	</style>
	
</head>
<body>

	<div class="container" style="margin-top: 30px">
		<div class="container1">
			<header>
				<div id="material-tabs">
					<a id="tab1-tab" href="#tab1" class="active">BUAT MODEL</a>
					<a id="tab2-tab" href="#tab2">TERAPKAN MODEL</a>
					<span class="yellow-bar"></span>
				</div>
			</header>

			<div class="tab-content">
				@include('_message')
				<div id="tab1">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							
							@if(file_exists('pyproject/train.csv')) 

							<p><span>Dataset tersedia</span> <a style="margin-left: 5px;" class="text-danger" href="{{ route('ds-train-delete') }}"><i class="fa fa-trash" aria-hidden="true"></i></a></p>

							@else

							<p><span>Dataset belum tersedia. Silahkan di-upload.</span></p>

							@endif
							
							<form action="{{ route('upload-train') }}" method="post" enctype="multipart/form-data">
								@csrf
								<input name="ds-train" type="file" class="form-control" required>
								<button style="margin-top: 10px" type="submit" class="btn btn-sm btn-primary">Upload</button>
							</form>

						</div>
						<div class="col-md-6 col-sm-12">
							@if(isset($acc) && isset($table) && $acc != null && $table != null)
							<p><span style="font-weight: bold">Akurasi</span>: {{ $acc }}</p>

							<p style="font-weight: bold; margin-top: 20px">Confusion matrix</p>
<pre>
{!! $table !!}
</pre>
							@endif
						</div>
					</div>
				</div>
				<div id="tab2">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							@if(file_exists('pyproject/full.csv')) 

							<p><span>Dataset tersedia</span> <a style="margin-left: 5px;" class="text-danger" href="{{ route('ds-full-delete') }}"><i class="fa fa-trash" aria-hidden="true"></i></a></p>

							@else

							<p><span>Dataset belum tersedia. Silahkan di-upload.</span></p>

							@endif
							
							<form action="{{ route('upload-full') }}" method="post" enctype="multipart/form-data">
								@csrf
								<input name="ds-full" type="file" class="form-control" required>
								<button style="margin-top: 10px" type="submit" class="btn btn-sm btn-primary">Upload</button>
							</form>

						</div>
						<div class="col-md-6 col-sm-12">
							@if(count($clData) > 0)
							<div class="table-responsive">
								<table class="table table-sm">
									<thead>
										<tr>
											<th>Kelas</th>
											<th>Jumlah Piksel</th>
											<th>Estimasi Luasan (Ha)</th>
											<th>Estimasi Luasan (%)</th>
										</tr>
									</thead>
									<tbody>
										@foreach($clData as $clItem)
										<tr>
											<td>{{ $clItem['class'] }}</td>
											<td>{{ $clItem['pixel'] }}</td>
											<td>{{ $clItem['luas_in_ha'] }} Ha</td>
											<td>{{ $clItem['luas_in_percent'] }}%</td>
										</tr>
										@endforeach
									</tbody>
								</table>
							</div>
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript" src="jquery.js"></script>
	<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

	<script type="text/javascript">
		$(document).ready(function() {
			$('#material-tabs').each(function() {

				var $active, $content, $links = $(this).find('a');

				$active = $($links[0]);
				$active.addClass('active');

				$content = $($active[0].hash);

				$links.not($active).each(function() {
					$(this.hash).hide();
				});

				$(this).on('click', 'a', function(e) {

					$active.removeClass('active');
					$content.hide();

					$active = $(this);
					$content = $(this.hash);

					$active.addClass('active');
					$content.show();

					e.preventDefault();
				});
			});
		});
	</script>
</body>
</html>
