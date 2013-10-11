<?php
// ** Get the Smiley Front End Configuration Information ** //
//Require the main configuration
require_once(__DIR__ . '/inc/config.php');
require_once(__DIR__ . '/inc/smiley-config.php');
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
<title>ZippyKid Customer Happiness Report</title>
<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css">
<link rel="stylesheet" href="assets/css/foundation.css">
<link rel="stylesheet" href="assets/css/layout.css">
<script src="assets/js/custom.modernizr.js"></script>
<!--[if lt IE 9]>
	<script type="text/javascript" src="assets/js/html5shiv.js"></script>
	<script type="text/javascript" src="assets/js/respond.min.js"></script>
<![endif]-->

<?php
//Conditionally include Google Analytics
if ( file_exists(__DIR__ . '/inc/analytics.php') ) {
	require_once(__DIR__ . '/inc/analytics.php');
}
?>

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
			<h1 class="site-title"><i class="icon-smile icon-2x happy"></i><br>ZippyKid Customer Happiness Report</h1>
		</div>
	</header><!-- #masthead -->

	<div class="row">
		<div class="large-6 columns">
			<h4>How are these ratings gathered?</h4>
			<p>After a ticket has been closed through our support portal, customers receive an email that requests an assessment of the experience by clicking one of three ratings: “Awesome” (smiley face), “Just OK” (neutral face), or “Not Good” (sad face). <a href="/assets/img/survey.png">Here’s what the choices look like</a> on the ticket.</p>
			
			<h4>Why do we do it?</h4>
			<p>We gather these ratings so that we can constantly monitor the satisfaction of our customers and performance of our Happiness Delivery Team. We’re always looking for ways to do better, and these ratings are shared with the whole company on a weekly basis to help us improve.</p>

			<h4>Why is it public?</h4>
			<p>We believe that we provide the best platform for WordPress hosting and the best support in the industry to match that. Instead of telling you that, we prove it with real ratings from real customers.</p>
		</div>
		
		<div class="large-6 columns">
			<div class="card panel">
				<h4 class="card-title">The Last 100 Customer Ratings</h4>
				<?php smileyRatings(); ?>
			</div>
			
			<div class="row">
				<p class="quote text-center"><i>“I started ZippyKid because I felt many clients were spending too much time thinking about optimizing their servers for WordPress, instead of using WordPress to grow their business. With each happy customer, we achieve our mission to help clients get back to what matters most, like creating great content and building amazing WordPress websites.”</i><br /> - <strong>Vid Luther, CEO & Founder at ZippyKid</strong></p>
			</div>
		</div>
		
	</div>
	
	<hr />
	
	<div class="row">
		<div class="large-12 large-centered columns">
			<h2 class="text-center">Our Happiness Delivery Team</h2>
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
			<h2 class="text-center">Customer Happiness is what we believe.</h2>
			<p>We're rated highest in customer satisfaction because of our superior hosting architecture and dependable customer service. Our team looks for opportunities to go above and beyond at every interaction so that you can spend less time dealing with hosting and more time making your customers happy. We focus on customer happiness instead of customer acquisition.</p>
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