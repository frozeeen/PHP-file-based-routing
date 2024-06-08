<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script type="text/javascript" src="<?php echo ASSETS; ?>/app.js" ></script>
	<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center h-screen w-screen" >
	<section class="mx-auto p-12 border rounded-md space-y-6" >
		<div>
			<h1 class="font-semibold text-xl font-mono" >PHP File-based router</h1>
			<div>Now go, build something</div>
		</div>

		<div>
			<p>GET REQUEST</p>
			<div>
				<div class="text-gray-500" >
					<a class="hover:underline hover:text-blue-500" href="your-awesome-page">Awesome page</a> |
					<a class="hover:underline hover:text-blue-500" href="post">Post</a> |
					<a class="hover:underline hover:text-blue-500" href="post/ABCDEFG">Show post</a> | 
					<a class="hover:underline hover:text-blue-500" href="auth">Auth</a> |
					<a class="hover:underline hover:text-blue-500" href="auth/nested">Invalid Auth</a>
				</div>
			</div>
		</div>

		<div>
			<p>POST REQUEST</p>
			<form method="POST" action="post" >
				<button class="text-sm bg-gray-400 hover:bg-blue-500 text-white rounded-md p-2" >Create post</button>
			</form>
			<p class="text-xs text-gray-400 mt-1" >The action of this form is `post`</p>
		</div>

	</section>
</body>
</html>