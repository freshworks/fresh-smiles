<?php
// ** Get the Smiley Front End Configuration Information ** //
//Require the main configuration
if ( $_SERVER['APP_ENV'] == 'production' ) {
  require_once(__DIR__ . '/inc/config-pagodabox.php');
} else {
  require_once(__DIR__ . '/inc/config.php');
}
if ( $_SERVER['APP_ENV'] == 'production' ) {
	require_once(__DIR__ . '/inc/smiley-config-pagodabox.php');
} else {
	require_once(__DIR__ . '/inc/smiley-config.php');
}
require_once(__DIR__ . '/inc/lib.php');

//Connect to MySQL
mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
@mysql_select_db(DB_NAME) or die("Unable to select database");

?>

<!DOCTYPE html>
<!--[if IE 8]> 				 <html class="no-js lt-ie9" lang="en-US" > <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en-US" > <!--<![endif]-->
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Smiles</title>
<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css">
<link rel="stylesheet" href="assets/css/foundation.css">
<link rel="stylesheet" href="assets/css/layout.css">
<script src="assets/js/custom.modernizr.js"></script>
<!--[if lt IE 9]>
	<script type="text/javascript" src="assets/js/html5shiv.js"></script>
	<script type="text/javascript" src="assets/js/respond.min.js"></script>
<![endif]-->
</head>
<body>

<div class="row logo">
	<div class="large-12 columns">
		<a title="The leader in WordPress Hosting" href="http://www.zippykid.com"><img src="assets/img/new-logo.png" /></a>
	</div>
</div>

<div id="page" class="site">

	<header id="masthead" class="site-header" role="banner">
		<div class="site-branding">
			<h1 class="site-title"><i class="icon-smile icon-2x happy"></i><br>ZippyKid Customer Support<br>Happiness Report</h1>
		</div>
	</header><!-- #masthead -->

	<div class="row">
		<div class="large-6 columns">
			<h4>How we measure customer happiness</h4>
			<p>After every interaction with our support team, a customer is asked to rate the experience by clicking one of three ratings: “It was great” (happy face), “It was OK” (flat-line face), or “It wasn’t good” (frown face). <a href="/assets/img/survey.png">Here’s what the choices look like</a> on the ticket.</p>
			
			<h4>This is how we get better</h4>
			<p>We study these ratings to help us improve. Every customer interaction is an opportunity to get better. The ultimate goal is 100% happiness.</p>

			<h4>Full transparency and accountability</h4>
			<p>We’ve made these ratings public so everyone knows how we’re doing. We want to be held to the highest possible standards for customer service. Full transparency keeps us honest.</p>
		</div>
		
		<div class="large-6 columns">
			<div class="card panel">
				<h4 class="card-title">Last 100 customer ratings</h4>
				<?php smileyRatings(); ?>
			</div>
		</div>
		
	</div>
	
	<hr />
	
	<div class="row">
		<div class="large-12 large-centered columns">
			<h2 class="text-center">The team that makes our customers happy</h2>
			<div class="row">
				<div class="list-centered">
					<ul>
					<?php foreach( $support_emails as $name => $email ) {
					$hash = gravatarHash($email); ?>
						<li class="large-block-grid-4">
							<img class="gravatar" src="http://www.gravatar.com/avatar/<?php echo $hash; ?>?s=75" />
							<p class="text-center support-name"><?php echo $name; ?></p>
						</li>
					<?php } ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
	
	<hr />
	
	<div class="row">
		<div class="large-12 large-centered columns">
			<h2 class="text-center">The last 100 customer support ratings.</h2>
			<?php hundredSmiles(); ?>
		</div>
	</div>
	
	<hr />
	
	<div class="row">
		<div class="large-12 large-centered columns">
			<h2 class="text-center">We strive for happiness — not satisfaction.</h2>
			<p>The customer service industry is obsessed with “customer satisfaction”. We believe that’s too low a bar. Satisfaction is not a measure of success — it’s just enough to get by. We want our customers to be happy. Happiness is success. Happiness is our goal.</p>
		</div>
	</div>
	
	<footer id="colophon" class="site-footer" role="contentinfo">
	
	</footer><!-- #colophon -->

</div><!-- #page -->

<div class="row">
	<div class="large-12 large-centered columns pitch">
		<h2 class="text-center">Interested in becoming a customer?</h2>
		<p>Freelance Developers, Agencies, Fortune 500 Companies and Educational Institutions all trust us to keep WordPress running and make them smile.
		<p class="text-center"><a href="https://my.zippykid.com/signup/?ref=smiley" class="button radius">Sign Up Now</a></p>
	</div>
</div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="assets/js/holder.min.js"></script>
</body>
</html>