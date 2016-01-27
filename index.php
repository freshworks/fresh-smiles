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
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Freshdesk Customer Happiness Report</title>
        <link rel="shortcut icon" href="favicon.ico" />
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" href="css/main.css">
        <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600' rel='stylesheet' type='text/css'>
        <script src="js/vendor/html5shiv.js"></script>
        <!--[if lt IE 9]>
            <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
            <script>window.html5 || document.write('<script src="js/vendor/html5shiv.js"><\/script>')</script>
        <![endif]-->
    </head>
    <body>
        <!--[if lt IE 9]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <script type="text/javascript">
        function constructSmiles(smiles) {
        	var length = smiles.length,
        		classes = {1: 'happy_smiley', 2: 'okay_smiley', 3: 'sad_smiley'} ;

        	var hundred = document.getElementById('hundred-smiles');
        	for (var i = 0; i < length; i++) {
        		var span = document.createElement('span');
        		span.className = classes[smiles[i]];
        		hundred.appendChild(span);
        	};
        }
        </script>

        <div class="cr_wrapper cf">

            <!--Header-->
            <header class="cr_page cf">
                <img src="img/freshdesk_logo.png" alt="freshdesk_logo" class="logo">
            </header>

            <!--Banner section-->
            <section class="cr_banner cf">
                <h1 class="text_center">Customer Happiness Report</h1>
<?php
//Conditionally include Google Analytics
if ( file_exists(__DIR__ . '/inc/analytics.php') ) {
	require_once(__DIR__ . '/inc/analytics.php');
}
?>
                <h2 class="text_center">Based on Last 100 Customer Ratings updated every 4 hours</h2>
                <div class="cr_page cf top_space">
                    <div class="cr_feedback">
                        <h3>I can finally relax</h3>
                        <blockquote>
                            “We were testing a lot of Helpdesk systems, but Freshdesk was clearly the best. We now offer multi-brand support to our customers in Slovakia, the Czech Republic, Poland and Russia!”  
                        </blockquote>
                        <p> <span>- Jana Kalasova </span> <img src="img/customer_logo.png" alt="customer_logo" width="123" height="18" ></p>
                    </div>

                    <div class="cr_main_report">
                        <div class="main_smiley cf">
                            <img src="img/smiley_happy_big.png" alt="customer-happy">
                            <div class="report_message_wrap">
                                <?php displayOverall() ?>
                            </div>
                        </div>
                       
                    </div>

                </div>
            </section>

            <!--Content section-->

            <section class="cr_page">

                <!-- description widgets section -->
                <div class="top_space cf">
                    <div class="cr_description_widget">
                        <h4>Where do these metrics come from?</h4>
                        <p>
                        	From you, our customers. 
                        	Everytime we resolve one of your tickets, you get an email asking you for feedback on your recent support experience. 
                        	This report is a collection of the last 100 ratings we got from customers like you.
                        </p>
                    </div>

                    <div class="cr_description_widget">
                        <h4>What do they mean?</h4>
                        <p>
                        	Quite a bit, actually.
                        	We believe every single support ticket is a  chance to wow a customer. 
							And every time we get a “not good” or “ok” response, it kills us a bit. 
							The report is a good indicator of how well we’ve been on our mission. 
                        </p>
                    </div>

                    <div class="cr_description_widget">
                        <h4>Why is it public?</h4>
                        <p>
                        	We think throwing our support ratings open to the world works way better than 
                        	just promising you great support and transparency with words. 
                        	Plus, we are accountable for making you delirious with joy. 
                        	And here’s to prove it. 
                        </p>
                    </div>
                </div>

                <!-- Agents section -->
                <div class="cf cr_agents cf">
                    <h2 class="text_center">Customer Happiness Heroes</h2>
                    <ul class="text_center top_space">
					<?php foreach( $support_emails as $name => $email ) {
					$hash = gravatarHash($email); ?>
						<li>
							<img class="gravatar" src="http://www.gravatar.com/avatar/<?php echo $hash; ?>?s=75" />
							<span><?php echo $name; ?></span>
						</li>
					<?php } ?>
					</ul>
                </div>

                <!-- Support customer ratings -->

                <div class="cf cr_ratings cf">
                    <h2 class="text_center">The last 100 customer support ratings.</h2>
                    <div class="top_space" id="hundred-smiles">
                        
                    </div>
                </div>
                <script type="text/javascript">
                	constructSmiles(<?= hundredSmiles() ?>);
                </script>

                <div class="top_space cf">
                    <h2 class="text_center">Happy Customers Say Cheese.</h2>
                    <p class="text_center">
                        We are a customer support company. Which means making customers happy isn’t just a metric for us - it’s our business. <br />
                        <big><strong><a href="http://freshdesk.com/say-cheese">Showcase your support ratings and let your customers Say Cheese with Fresh Smiles.</a></strong></big>
                        <br /><br /><br />
                    </p>
                </div>

            </section>
        </div>
    </body>
</html>
