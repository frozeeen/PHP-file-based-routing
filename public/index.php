<?php
	/**
	 * Require the entry of the router, which is used for finding the correct page in the `pages` folder
	 * Also requireing the helpers, which contains functions like load templates and throw404
	 */
	require ".." . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "app.php";
	require ".." . DIRECTORY_SEPARATOR . "router" . DIRECTORY_SEPARATOR . "helpers.php";
	require ".." . DIRECTORY_SEPARATOR . "router" . DIRECTORY_SEPARATOR . "bootstrap.php";

	/**
	 * If your projects needs to use composer, you can include it here if you want it global
	 * https://getcomposer.org/
	 */
	// require ".." . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";

	/**
	 * Some configurations and database connections if you needed some
	 */
	// require ".." . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "connection.php";

	/**
	 * Execute the router
	 */
	executeRouter($_GET['__url__'] ?? 'index', $_SERVER["REQUEST_METHOD"]);