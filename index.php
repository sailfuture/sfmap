<!DOCTYPE html>
<html lang="en">
<html class="no-js">
<head>
	<meta charset="utf-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

<?php wp_head(); ?>
		<title>Hello, world!</title>
		<style>
		.fixy {
			position: absolute;
		}

		.fixy.i1 {
			width:40%;
			height:100%;
			margin-right:10%;
			float:right;
		}

		.fixy.i2 {
			width:10%;
			height:100%;
			right:0px;
		}

		.fixy.i3 {
			width:20%;
			height:100%;
			right:10%;
		}

		div.lists.active {

		}

		.bg-secondary {
			color:white!important;
		}

		.mapmaster {
			position:fixed;
			width:70%;
			height:calc(100% - 75px);
			z-index: 0;
		}

		a {
			cursor: pointer;
		}

		.pointer {
			cursor: pointer;
		}


		</style>
		<script src="https://sailfuture.org/map/wp-content/themes/twentyfifteen-child_103/twentyfifteen-child/js/leaflet.js"></script>
		<script src='https://api.mapbox.com/mapbox.js/v3.1.1/mapbox.js'></script>
		<link href='https://api.mapbox.com/mapbox.js/v3.1.1/mapbox.css' rel='stylesheet' />
		<script src='https://sailfuture.org/map/wp-content/themes/twentyfifteen-child_103/twentyfifteen-child/js/reqwest.min.js'></script>
		<script src='https://sailfuture.org/map/wp-content/themes/twentyfifteen-child_103/twentyfifteen-child/js/Leaflet.MakiMarkers.js'></script>
		<script src='https://sailfuture.org/map/wp-content/themes/twentyfifteen-child_103/twentyfifteen-child/js/Leaflet.SpotTracker.js'></script>

</head>

<body>

		<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
		  <a class="navbar-brand" href="#">Navbar w/ text</a>
		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
		    <span class="navbar-toggler-icon"></span>
		  </button>
		  <div class="collapse navbar-collapse" id="navbarText">
		    <ul class="navbar-nav mr-auto">
		      <li class="nav-item active">
		        <a class="nav-link" href="/single-page">Home <span class="sr-only">(current)</span></a>
		      </li>
		      <li class="nav-item">
		        <a class="nav-link" href="#">Features</a>
		      </li>
		      <li class="nav-item">
		        <a class="nav-link" href="#">Pricing</a>
		      </li>
		    </ul>
		    <span class="navbar-text">
		      Navbar text with an inline element
		    </span>
		  </div>
		</nav>

<div id="map" class="mapmaster"></div>

<div class="container-fluid">
	<div class="row" style="background-color:#fff">

	<div id="place" class="card fixy i1 px-4 py-4 pt-0 postshow" style="background-color:#fff">
	</div>

	<div id="places" class="fixy i3 p-4" style="background-color:#efefef;overflow: auto;">
		<div class="">
				<ul id="places-list">
					<?php
						$args = array(
							'date_query' => array(
								array(
									//'month' => 1
								),
							),
						);
						$q = new WP_Query( $args );
						if( $q->have_posts() ) {
							while( $q->have_posts() ) {

								$q->the_post();

								$cat_collection = get_the_category();
								?>

								<li class="ajax-post-call mb-4 pointer" id="postID<?php echo get_the_ID(); ?>" data-post-id="<?php echo get_the_ID(); ?>" href="">
									<a href="#" class="lists active">
<div class="card stacked" href="">
	<?php the_post_thumbnail( 'full', array( 'class' => 'card-img-top' ) ); ?>
	<div class="card-body">
		<h5 class="card-title"><?php the_title(); ?></h5>
		<p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
		<a href="#" class="btn btn-primary">Go somewhere</a>
	</div>
	<div class="card-footer">
<small class="text-muted"><?php echo $cat_collection[0]->name; ?></small>
</div>
</div>
									</a>
								</li>
								<?php
							}

						}
					?>
				</ul>
		</div>
	</div>


		<!--<nav id="top-menu" class="menu top-menu">
			<ul>
				<li><a id="toggle-overlay">About</a></li>
			</ul>
		</nav>-->
<div class="fixy i2 p-4 bg-secondary";>
		<nav id="bottom-menu">
			<ul class="list-group h-100">
				<li>
					<a href="#" class="post-month-ajax-call list-group-item active" data-month-id="0">All</a>
				</li>
				<li>
					<a href="#" class="post-month-ajax-call list-group-item" data-month-id="1">January</a>
				</li>
  <li class="list-group-item">Morbi leo risus</li>
  <li class="list-group-item">Porta ac consectetur ac</li>
  <li class="list-group-item">Vestibulum at eros</li>
</ul>
		</nav>
		</div>
	</div>
</div>

	<nav id="mobile-menu" class="menu mobile-menu">
		<div id="home-nav" class="mobile-nav home-nav">
			<a class="mobile-logo"><span></span></a>
			<ul>
				<li class="mobile-filter-button"><a id="mobile-toggle-filter">Filter</a></li>
				<li class="mobile-search-button hidden">
					<form id="search-form" role="search" method="get" class="search-form" action="" autocomplete="off">
						<input id="search-box" type="text" placeholder="Search" value="" />
						<input type="submit" class="search-submit" value="Search">
					</form>
				</li>
			</ul>
		</div>
		<div id="single-nav" class="mobile-nav single-nav">
			<a id="close-mobile" class="close-mobile"></a>
			<ul>
				<li class="directions"><a id="directions" rel="external">Directions</a></li>
			</ul>
		</div>
		<div id="overlay-nav" class="mobile-nav overlay-nav">
			<a id="close-overlay" class="close-mobile"></a>
		</div>
	</nav>

	<nav id="mobile-filter" class="menu mobile-filter">
		<ul>
			<li>
				<a href="#" class="post-month-ajax-call active" data-month-id="0">All</a>
			</li>
			<li>
				<a href="#" class="post-month-ajax-call" data-month-id="1">January</a>
			</li>
			<li>
				<a href="#" class="post-month-ajax-call" data-month-id="2">February</a>
			</li>
			<li>
				<a href="#" class="post-month-ajax-call" data-month-id="3">March</a>
			</li>
			<li>
				<a href="#" class="post-month-ajax-call" data-month-id="4">April</a>
			</li>
			<li>
				<a href="#" class="post-month-ajax-call" data-month-id="5">May</a>
			</li>
			<li>
				<a href="#" class="post-month-ajax-call" data-month-id="6">June</a>
			</li>
			<li>
				<a href="#" class="post-month-ajax-call" data-month-id="7">July</a>
			</li>
			<li>
				<a href="#" class="post-month-ajax-call" data-month-id="8">Auguest</a>
			</li>
			<li>
				<a href="#" class="post-month-ajax-call" data-month-id="9">September</a>
			</li>
			<li>
				<a href="#" class="post-month-ajax-call" data-month-id="10">October</a>
			</li>
			<li>
				<a href="#" class="post-month-ajax-call" data-month-id="11">November</a>
			</li>
			<li>
				<a href="#" class="post-month-ajax-call" data-month-id="12">December</a>
			</li>
		</ul>
	</nav>

	<div id="intro" class="full intro">
		<div id="intro-content" class="table">
			<div class="table-cell">
				<h1>THIS ONE v3</h1>
				<div class="intro-text">Thanks for your Interesting</div>
			</div>
		</div>
	</div>


<script type="text/javascript">


	// marker.on('click', function() {
	//     $(marker._icon).addClass('ajax-post-call');
	// });


	function markerOnClick(e) {
	    map.setView(e.target.getLatLng(),10);

	}

	(function($) {

		$('#place').css({
			'left' : '100%'
		});

	}(jQuery));

</script>



<?php wp_footer(); ?>
<script src="https://code.jquery.com/jquery-3.3.1.min.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src='http://ht.wtf/wp-content/themes/twentyfifteen-child_PHP/js/Mapper.js?ver=3.0'></script>
</body>

</html>
