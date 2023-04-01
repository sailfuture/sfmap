<!DOCTYPE html>
<html class="no-js">

<head>
	<meta charset="utf-8" />
	<meta property="og:url"                content="http://map.sailfuture.org/" />
	<meta property="og:type"               content="website" />
	<meta property="og:title"              content="SailFuture Live Map" />
	<meta property="og:description"        content="Follow Defy The Odds and our crew live as they sail the Caribbean over the next three months." />
	<meta property="og:image"              content="https://s3.us-east-2.amazonaws.com/sailfuture.org/map_facebook.jpg" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

<?php wp_head(); ?>
<style>
.mapmaster {
	position:fixed;
	width:calc(100% - 186px);
	height:calc(100% - 0px);
	z-index: 0;
}

#bitnami-banner {
	display:none;
}

.leaflet-marker-live {
     -webkit-animation: pulse 2s ease-out;
     animation: pulse 2s ease-out;
     -webkit-animation-iteration-count: infinite;
     animation-iteration-count: infinite;
    }

    @-webkit-keyframes pulse {
      from { stroke-width: 15; stroke-opacity: 1; }
      to { stroke-width: 50; stroke-opacity: 0; }
    }

    @keyframes pulse {
      from { stroke-width: 15; stroke-opacity: 1; }
      to { stroke-width: 50; stroke-opacity: 0; }
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

	<div id="map" class="mapmaster"></div>


	<div id="place" class="place">
		<div id="place-content" class="scroller">

		</div>
		<a id="close-place" class="close-place"></a>
	</div>

	<div id="places" class="places">
		<div class="scroller">
			<div class="scroll-container">
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
								<li class="ajax-post-call" id="postID<?php echo get_the_ID(); ?>" data-post-id="<?php echo get_the_ID(); ?>">
									<a href="#">
										<div class="mask img-holder cover-img loading">
											<?php the_post_thumbnail(); ?>
										</div>
										<span class="title"><?php the_title(); ?></span>
										<!-- <span class="cats"><?php echo $cat_collection[0]->name; ?></span> -->
									</a>
								</li>
								<?php
							}

						}
					?>
				</ul>
			</div>
		</div>
	</div>

	<div id="overlay" class="overlay">
		<div class="scroller">
			<div class="scroll-container">
				<div id="about" class="about">
					<div class="table">
						<div class="table-cell">
							<div class="centered">

								<h1>WELCOME</h1>
								<div class="intro-text">Thanks for your Interesting</div>

							</div>
						</div>
					</div>
					<div class="copyright">

					</div>
				</div>

			</div>
		</div>


		<!--<nav id="top-menu" class="menu top-menu">
			<ul>
				<li><a id="toggle-overlay">About</a></li>
			</ul>
		</nav>-->

		<nav id="bottom-menu" class="menu bottom-menu">
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
				<h1>WELCOME</h1>
				<div class="intro-text">Thanks for your Interesting</div>
			</div>
		</div>
	</div>


<script type="text/javascript">

function markerOnClick(e) {
		map.setView(e.target.getLatLng(),10);
}

	(function($) {

		$('.intro').css({
			'left' : '2000px',
			'transition' : '1s',
			'display' : 'none'
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
