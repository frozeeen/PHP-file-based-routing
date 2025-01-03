<?php
	/**
	 * Router Prototype
	 */

	/**
	 * Enums and Declarations
	 */
	enum FileType: int {
		case DIRECTORY = 0;
		case FILE = 1;
	}
	
	function executeRouter($url, $request_method){
		
		/**
		 * Initialize the query string
		 */
		$REQUEST_URI = explode('/', $url);
		$REQUEST_DEPTH = count($REQUEST_URI);

		/**
		 * Find the page in the folder
		 */
		$destination_path = ENTRY_FOLDER;
		$current_type = FileType::DIRECTORY->value;
		$is_not_found = false;
		$middleware_path = false;
		$middleware_file_name = "+middleware.php";
		$middleware_global_file_name = "+middleware.global.php";
		$registered_middlewares = [];

		# Check Request Method
		$request_method = strtolower($request_method);
		$valid_request_methods = ["get", "post", "delete", "put", "patch"];
		if( !in_array($request_method, $valid_request_methods) ){
			$REQUEST_DEPTH = 0;
		}

		for($r = 0; $r < $REQUEST_DEPTH; $r++){
			$part = $REQUEST_URI[$r];
			
			# Check if a global middleware exist
			if( file_exists($destination_path . DIRECTORY_SEPARATOR . $middleware_global_file_name) ){
				$registered_middlewares[] = $destination_path . DIRECTORY_SEPARATOR . $middleware_global_file_name;
			}

			$moving_path = $destination_path . DIRECTORY_SEPARATOR . $part;

			# Check for middlewares
			if( file_exists($destination_path . DIRECTORY_SEPARATOR . $middleware_file_name) ){
				$middleware_path = $destination_path . DIRECTORY_SEPARATOR . $middleware_file_name;
			}

			# Check if a raw file exist
			if( file_exists($moving_path . DIRECTORY_SEPARATOR . $middleware_file_name) ){
				$middleware_path = $moving_path . DIRECTORY_SEPARATOR . $middleware_file_name;
			}

			if( $part == '' ) continue;

			$with_extension = $moving_path . "." . $request_method . ".php";
			if( file_exists($with_extension) ){
				$destination_path = $with_extension;
				$current_type = FileType::FILE->value;
				$is_not_found =  $r != $REQUEST_DEPTH - 1;
				break;

			# Move inside the folder
			}else if( is_dir($moving_path) == 1 ){
				$destination_path = $moving_path;
				$current_type = FileType::DIRECTORY->value;

			# Find the `[slug]`
			}else{
				$is_slug_found = false;
				$is_slugged = false;
				$scanned_dir = scandir($destination_path);

				for($i = 2, $x = count($scanned_dir); $i < $x; $i++){
					if( str_contains($scanned_dir[$i], '[') ){

						# Slug folder
						if( str_contains($scanned_dir[$i], '.') == false ){
							$_GET[substr($scanned_dir[$i], 1, -1)] = $part;
							$destination_path = $destination_path . DIRECTORY_SEPARATOR . $scanned_dir[$i];
							$current_type = FileType::DIRECTORY->value;
							
							# Slug file
						}else if( $r == $REQUEST_DEPTH - 1 ){
							$file_name = explode('.', $scanned_dir[$i])[0];
							$_GET[substr($file_name, 1, -1)] = $part;
							$destination_path = $destination_path . DIRECTORY_SEPARATOR . $file_name . '.' . $request_method . '.php';
							$current_type = FileType::FILE->value;
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
		
		/**
		 * Check if the last iteration is already a file
		 */
		$index_file = "index.". $request_method .".php";
		if( $current_type == FileType::DIRECTORY->value && file_exists($destination_path . DIRECTORY_SEPARATOR . $index_file) ){
			if( file_exists($destination_path . DIRECTORY_SEPARATOR . $middleware_global_file_name) ){
				$registered_middlewares[] = $destination_path . DIRECTORY_SEPARATOR . $middleware_global_file_name;
			}
			
			$destination_path .= DIRECTORY_SEPARATOR . $index_file;
		}else if( $current_type == FileType::DIRECTORY->value && $is_not_found == false ){
			throw404();
		}

		/**
		 * Run global middlewares
		 */
		foreach ($registered_middlewares as $global_mwpath) {
			require_once $global_mwpath;
		}

		/**
		 * Run the last Middleware
		 */
		if( $middleware_path ){
			require_once $middleware_path;
		}
		
		/**
		 * Load the selected page
		 */
		if( file_exists($destination_path) && $is_not_found == false ){
			require_once $destination_path;
		}else{
			throw404();
		}

	}