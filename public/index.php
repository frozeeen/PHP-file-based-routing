<?php
	/**
	 * Require the entry of the router, which is used for finding the correct page in the `pages` folder
	 * Also requireing the helpers, which contains functions like load templates and throw404
	 */
	require ".." . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "config.php";
	require ".." . DIRECTORY_SEPARATOR . "router" . DIRECTORY_SEPARATOR . "helpers.php";
	require ".." . DIRECTORY_SEPARATOR . "router" . DIRECTORY_SEPARATOR . "bootstrap.php";

	/**
	 * If your projects needs to use composer, you can include it here if you want it global
	 * https://getcomposer.org/
	 */
	// require "vendor/autoload.php";

	/**
	 * Some configurations and database connections if you needed some
	 */
	// require "config/connection.php";