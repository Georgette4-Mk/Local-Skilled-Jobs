
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Portal</title>
    <link rel="stylesheet" href="main dashboard.css">
</head>
<body>
    <!-- Header Section -->
    <header class="header">
        <nav class="navbar">
            <div class="logo">Local Jobs</div>
            <ul class="nav-links">
                <li><a href="Employee/applications">Find Jobs</a></li>
                <li><a href="Emplyer_Dashbord">Post a Job</a></li>
            </ul>
            <div class="auth-buttons">
            <?php

            session_start();

            if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
                echo '<a href="logout.php"><button class="register">Logout</button></a>';
            } else {
                echo '<a href="login.php"><button class="login">Sign In</button></a>
                      <a href="signup.php"><button class="register">Sign Up</button></a>';
            }
            ?>
            <!-- <a href="login.php"><button class="login">Sign In</button> 
            <a href="signup.php"><button class="register">Sign Up</button>
            <a href="logout.php"><button class="register">Logout</button>-->
            </div>
        </nav>
        <div class="hero">
            <h1>The Perfect place for your <span class="highlight">SKILLS</span></h1>
            <p>Put your skills into use with our platform</p>
            <form class="search-bar" action="search_jobs.php" >
                
                <input type="text" placeholder="Jobs" name="search_query">
                <input type="text" placeholder="Location" name="location">
                <button type="submit">Search Jobs</button>
            </form>
            <div class="trusted-by">
                <p>Trusted by:</p>
                <div class="trusted-companies">
                    <img src="images/Afayi.jpg" alt="Afayi">
                </div>
            </div>
        </div>
    </header>

    <!-- Categories Section -->
    <section class="categories">
        <h2>Explore by <span class="highlight">category</span></h2>
        <div class="category-cards">
            <div class="category-card"><img src="images/capenter.jpg" alt="Carpenter" height="60px" width="60px">           Carpenter</div>
            <div class="category-card"><img src="images/chef.jpg" alt="Cook" height="60px" width="60px">                    Cook</div>
            <div class="category-card"><img src="images/electrical.webp" alt="Electrician" height="60px" width="60px">      Electrician</div>
            <div class="category-card"><img src="images/plumbering.png" alt="Plumber" height="60px" width="60px">           Plumber</div>
            <div class="category-card"><img src="images/cleaning.jpg" alt="Cleaner" height="60px" width="60px">             Cleaner </div>
            <div class="category-card"><img src="images/barber.jpg" alt="Barber" height="60px" width="60px">                Barber</div>
        </div>
    </section>

    <!-- Start Posting Jobs Section -->
    <section class="posting-section">
        <div class="posting-promo">
            <h3>Start posting jobs today</h3>
            <p>Get started for as low as XAF15,00 per month</p>
            <button class="post-job-button" onclick="Location:'post_job.html'">Start Posting</button>
        </div>
    </section>

    <!-- Featured Jobs Section --> 
    <section class="featured-jobs">
        <h2>Featured <span class="highlight">jobs</span></h2>
        <div class="job-cards">
            <div class="job-card">Job 1</div>
            <div class="job-card">Job 2</div>
            <div class="job-card">Job 3</div>
            
        </div>
    </section>

    <!-- Latest Jobs Open Section -->
    <section class="latest-jobs">
        <h2>Latest <span class="highlight">jobs open</span></h2>
        <div class="job-cards">
            <div class="job-card">Job 1</div>
            <div class="job-card">Job 2</div>
            <div class="job-card">Job 3</div>
            
        </div>
    </section>

    <!-- Footer Section -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-logo">Local Jobs</div>
            <div class="footer-links">
                <a href="about section.html">About</a>
                <a href="#">Contact</a>
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Service</a>
            </div>
            <div class="subscribe">
                <p>Subscribe to our newsletter</p>
                <input type="email" placeholder="Enter your email">
                <button type="submit">Subscribe</button>
            </div>
        </div>
    </footer>
<!-- Code injected by live-server -->
<script>
	// <![CDATA[  <-- For SVG support
	if ('WebSocket' in window) {
		(function () {
			function refreshCSS() {
				var sheets = [].slice.call(document.getElementsByTagName("link"));
				var head = document.getElementsByTagName("head")[0];
				for (var i = 0; i < sheets.length; ++i) {
					var elem = sheets[i];
					var parent = elem.parentElement || head;
					parent.removeChild(elem);
					var rel = elem.rel;
					if (elem.href && typeof rel != "string" || rel.length == 0 || rel.toLowerCase() == "stylesheet") {
						var url = elem.href.replace(/(&|\?)_cacheOverride=\d+/, '');
						elem.href = url + (url.indexOf('?') >= 0 ? '&' : '?') + '_cacheOverride=' + (new Date().valueOf());
					}
					parent.appendChild(elem);
				}
			}
			var protocol = window.location.protocol === 'http:' ? 'ws://' : 'wss://';
			var address = protocol + window.location.host + window.location.pathname + '/ws';
			var socket = new WebSocket(address);
			socket.onmessage = function (msg) {
				if (msg.data == 'reload') window.location.reload();
				else if (msg.data == 'refreshcss') refreshCSS();
			};
			if (sessionStorage && !sessionStorage.getItem('IsThisFirstTime_Log_From_LiveServer')) {
				console.log('Live reload enabled.');
				sessionStorage.setItem('IsThisFirstTime_Log_From_LiveServer', true);
			}
		})();
	}
	else {
		console.error('Upgrade your browser. This Browser is NOT supported WebSocket for Live-Reloading.');
	}
	// ]]>
</script>
</body>
</html>

