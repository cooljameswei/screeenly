<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Screenly</title>
	<style>
		@import url(//fonts.googleapis.com/css?family=Lato:700);

		body {
			margin:0;
			font-family:'Lato', sans-serif;
			text-align:center;
			color: #999;
		}

		.welcome {
			width: 300px;
			height: 200px;
			position: absolute;
			left: 50%;
			top: 50%;
			margin-left: -150px;
			margin-top: -100px;
		}

		a, a:visited {
			text-decoration:none;
		}

		h1 {
			font-size: 32px;
			margin: 16px 0 0 0;
		}
	</style>
</head>
<body>
	<div class="welcome">
		<h1>Screenly</h1>
		<p>API to get Screenshots from Websites</p>

		<hr>

		@if(Auth::check())
			<p>{{ link_to_route('oauth.logout', 'Logout') }}</p>
		@else
			<p>{{ link_to_route('oauth.github', 'Login via Github') }}</p>
		@endif

	</div>
</body>
</html>
