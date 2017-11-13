<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8" />
		<meta name="robots" content="all" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, minimum-scale=1.0" />
		<meta name="description" content="Hide and encrypt your data into an innocent picture" />
		<meta name="keywords" content="creepimage hide encrypt data image" />
		<meta property="og:title" content="creepImage" />
		<meta property="og:image" content="assets/images/fb_image.jpg" />
		<meta property="og:site_name" content="876.hu" />
		<link rel="canonical" href="http://876.hu/creepimage/" />
		<title>creepImage</title>

		<link rel="shortcut icon" type="image/png" href="assets/images/favicon.png" />

		<link
			href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
			rel="stylesheet"
			integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN"
			crossorigin="anonymous" />

		<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
		<link rel="stylesheet" href="assets/css/now-ui-kit.css" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<link rel="stylesheet" href="assets/css/loader.css" />
	</head>
	<body class="sidebar-collapse">
		<nav class="navbar navbar-expand-lg bg-info">
		    <div class="container">
		        <div class="navbar-translate">
		            <a class="navbar-brand">
		               creepImage
		           </a>
		            <button
		            		class="navbar-toggler navbar-toggler-right"
		            		type="button"
		            		data-toggle="collapse"
		            		data-target="#navigation"
		            		aria-controls="navigation-index"
		            		aria-expanded="false"
		            		aria-label="Toggle navigation">
			   	        <span class="navbar-toggler-bar bar1"></span>
				        <span class="navbar-toggler-bar bar2"></span>
				        <span class="navbar-toggler-bar bar3"></span>
			 	    </button>
		        </div>

		        <div class="collapse navbar-collapse justify-content-end" id="navigation">
		    	    		<?php $acutalUri = Route::getFacadeRoot()->current()->uri(); ?>
		    	    		<ul class="navbar-nav">
		                <li class="nav-item <?php echo ($acutalUri === 'encreeption' ? 'active' : ''); ?>">
		                    <a class="nav-link" href="/creepimage/encreeption">encreeption</a>
		                </li>
		                <li class="nav-item <?php echo ($acutalUri === 'decreeption' ? 'active' : ''); ?>">
		                    <a class="nav-link" href="/creepimage/decreeption">decreeption</a>
		                </li>

		                <li class="nav-item">
			                	<a class="nav-link"
				                	href="mailto:9@876.hu"
					            data-toggle="tooltip"
						        data-placement="bottom"
							    data-original-title="Send me a message">
								<i class="fa fa-envelope-square" aria-hidden="true"></i>
	                            <p class="d-lg-none d-xl-none">Email: 9@876.hu</p>
							</a>
		                </li>

		                <li class="nav-item">
			                	<a class="nav-link"
				                	href="https://www.linkedin.com/in/peter-suhajda/"
				                target="_blank"
					            data-toggle="tooltip"
						        data-placement="bottom"
							    data-original-title="Contact me on LinkedIn">
								<i class="fa fa-linkedin-square" aria-hidden="true"></i>
	                            <p class="d-lg-none d-xl-none">LinkedIn: Peter Suhajda</p>
							</a>
		                </li>

		                <li class="nav-item">
			                	<a class="nav-link"
				                	href="https://github.com/suhhip/creepimage"
				                target="_blank"
					            data-toggle="tooltip"
						        data-placement="bottom"
							    data-original-title="View source on GitHub">
								<i class="fa fa-github-square" aria-hidden="true"></i>
	                            <p class="d-lg-none d-xl-none">GitHub</p>
							</a>
		                </li>
		            </ul>
		        </div>
		    </div>
		</nav>

		<div class="container main-container">
			 @yield('content')

			 @component('layouts/_whatisthis')
			 @endcomponent
		</div>

		@component('layouts/_alert')
		@endcomponent

		<script src="assets/js/core/jquery.3.2.1.min.js"></script>
		<script src="assets/js/core/popper.min.js"></script>
		<script src="assets/js/core/bootstrap.min.js"></script>
		<script src="assets/js/core/now-ui-kit.js"></script>

		<script src="assets/js/app.js"></script>
		<script src="assets/js/jquery.alert.js"></script>
		<script src="assets/js/jquery.input-counter.js"></script>

		@yield('bodyendScript')
	</body>
</html>
