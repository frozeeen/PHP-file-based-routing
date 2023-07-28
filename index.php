<?php
	#|==================================
	#| Global settings
	#|==================================
	define("ASSETS", "http://localhost/php-file-based-routing/assets");
	define("ENTRY_FOLDER", "pages");

	#|==================================
	#| Initialize the query string
	#|==================================
	$REQUEST_URI = $_SERVER['QUERY_STRING'] == '' ? ['index'] : explode('/', $_GET['__url__']);
	$REQUEST_DEPTH = count($REQUEST_URI);
			
	#|==================================
	#| Find the page in the folder
	#|==================================
	$destination_path = ENTRY_FOLDER;
	$current_type = 0; // 0 Folder | 1 File
	$is_not_found = false;
	$middleware_path = false;
	$middleware_file_name = "+middleware.php";

	for($r = 0; $r < $REQUEST_DEPTH; $r++){
		$part = $REQUEST_URI[$r];
		$moving_path = ($destination_path . DIRECTORY_SEPARATOR . $part);

		# Check for middlewares
		if( file_exists($destination_path . DIRECTORY_SEPARATOR . $middleware_file_name) ){
			$middleware_path = $destination_path . DIRECTORY_SEPARATOR . $middleware_file_name;
		}

		if( file_exists($moving_path . DIRECTORY_SEPARATOR . $middleware_file_name) ){
			$middleware_path = $moving_path . DIRECTORY_SEPARATOR . $middleware_file_name;
		}

		if( $part == '' ) continue;

		# Check if a raw file exist
		$with_extension = str_contains($moving_path, '.') ? $moving_path : $moving_path . ".php";
		if( file_exists($with_extension) ){
			$destination_path = $with_extension;
			$current_type = 1;
			$is_not_found =  $r != $REQUEST_DEPTH - 1;
			break;

		# Move inside the folder
		}else if( is_dir($moving_path) == 1 ){
			$destination_path = $moving_path;
			$current_type = 0;

		}else{

			# Find the `[slug]`
			$is_slug_found = false;
			$is_slugged = false;
			$scanned_dir = scandir($destination_path);
			for($i = 2, $x = count($scanned_dir); $i < $x; $i++){
				if( str_contains($scanned_dir[$i], '[') ){

					# Slug folder
					if( str_contains($scanned_dir[$i], '.') == false ){
						$_GET[substr($scanned_dir[$i], 1, -1)] = $part;
						$destination_path = $destination_path . DIRECTORY_SEPARATOR . $scanned_dir[$i];
						$current_type = 0;

					# Slug file
					}else if( $r == $REQUEST_DEPTH - 1 ){
						$file_name = explode('.', $scanned_dir[$i])[0];
						$_GET[substr($file_name, 1, -1)] = $part;
						$destination_path = $destination_path . DIRECTORY_SEPARATOR . $scanned_dir[$i];
						$current_type = 1;
						$is_slugged = true;
					}

					$is_slug_found = true;
					break;
				}
			}

			$is_not_found = !$is_slug_found;
			if( $is_slugged || $is_not_found ){
				break;
			}
		}

	}

	#|==================================
	#| Check if the last iteration is already a file
	#|==================================
	if( $current_type == 0 && file_exists($destination_path . DIRECTORY_SEPARATOR . "index.php") ){
		$destination_path .= ( DIRECTORY_SEPARATOR . "index.php" );
	}else if( $current_type == 0 && $is_not_found == false ){
		$is_not_found = true;
	}

	#|==================================
	#|
	#| REQUIRE your scripts here before render
	#| 
	#|==================================
	# require_once ".backend/your_script.php";

	#|==================================
	#| Run the Middleware
	#|==================================
	if( $middleware_path ){
		require_once $middleware_path;
	}
	
	#|==================================
	#| Load the selected page
	#|==================================
	if( file_exists($destination_path) && $is_not_found == false ){
		require_once $destination_path;
	}else{
		require_once ENTRY_FOLDER . DIRECTORY_SEPARATOR . "404.php";
	}

	#|==================================
	#|
	#| REQUIRE your scripts here after render
	#|
	#|==================================
	# require_once ".backend/your_script.php";

?>