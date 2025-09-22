<!DOCTYPE html>
<html lang="en">

@include('layouts.shared.head')

<body>
	<main class="d-flex w-100">
		<div class="container d-flex flex-column">
			<div class="row vh-100">
				<div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
					<div class="d-table-cell align-middle">

						<div class="text-center mt-4">
							<h1 class="h2">@yield('page-title')</h1>
							<p class="lead">
								@yield('page-subtitle')
							</p>
						</div>

						@yield('content')
					</div>
				</div>
			</div>
		</div>
	</main>

	<script src="{{ asset('assets/admin') }}/js/app.js"></script>
</body>

</html>
