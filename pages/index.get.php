<!DOCTYPE html>
<html>
<head>
	<?php useTemplate("head") ?>
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

		<hr>

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