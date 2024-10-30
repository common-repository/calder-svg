<?php

/*
 * Plugin Name: Calder SVG
 * Plugin URI: http://www.maxizone.fr/
 * Description: JS animations based on prepared SVG files
 * Author: Max UNGER
 * Version: 2.1
 * Author URI: http://www.maxizone.fr/
 */
if (! defined ( 'ABSPATH' )) {
	exit (); // Exit if accessed directly
}




if (! class_exists ( 'CalderSVG_FilesFetcher' )) {
	class CalderSVG_FilesFetcher {
		public static $instance = NULL;
	
		function setUpLogger() {
			$log4phpVersion = '2.3.0';
			$path_to_log4php = sprintf ( '%s/libs/log4php/' . $log4phpVersion . '/Logger.php', dirname ( __FILE__ ) );
			if (!class_exists('LoggerConfiguratorDefault')){
				include_once($path_to_log4php);
			}
			//include_once($path_to_log4php);
			//Logger::configure('config.xml');
			$configurator = new LoggerConfiguratorDefault();
			$dir = plugin_dir_path( __FILE__ );
			$configPath = $dir . '/logs/config.xml';
			$config = $configurator->parse($configPath);
			Logger::configure($config);
		}
		public function __construct() {
			
		$this->setUpLogger();
			//caldersvg_log ( 'CalderSVG activated, __construct exacuted...' );
			// SHORTCODES
			// add_shortcode('caldersvg', array($this, 'svg_s_display_animation_fn'));
			add_shortcode ( 'caldersvg', array (
					$this,
					'caldersvg_display_animation_fn' 
			) );
			add_shortcode ( 'caldersvgjs', array (
					$this,
					'caldersvgjs_display_animation_fn' 
			) );
			add_action ( 'wp_enqueue_scripts', array (
					$this,
					'caldersvg_frontend_stylesheet' 
			) );
			
			//caldersvg_log ( '...CalderSVG init done' );
		}
		public function load_svg_from_folder($absFolder, $folder) {
			////error_log ( "inside load_svg_from_folder function" );			
			$filenames = glob ( $absFolder . '/*.svg' );
			
			$msg = count ( $filenames ) . " files retrieved in " . $absFolder;
			Logger::getLogger("default")->info ($msg);
			
			$xmlHeader = '<?xml version="1.0" encoding="utf-8"?>';
			$idx = 0;
			
			$recursiveCalls = 'callbackFunction';
			$pattern = '/callbackFunction/';
			
			$svgURLs = array ();
			$svgCanvas = '';
			// randomize
			shuffle ( $filenames );
			
			$upload_dir = wp_upload_dir ();
			$baseUrl = get_site_url();
			//caldersvg_log ( $upload_dir );
			foreach ( $filenames as $filename ) {
				
				// http://caldersvg.termel.fr/var/www/termel/wp-content/plugins/calder-svg/svg/musicians/paulmccartney.svg
				
				//$fullFileURL = str_replace ( $upload_dir ['basedir'], $upload_dir ['baseurl'], $filename );
				//caldersvg_log ( $filename . ' -> ' . $fullFileURL );
				//$fullFileURL
				Logger::getLogger("default")->info ( $filename);
				if (! file_exists ( $filename ) || ! is_readable ( $filename )) {
					
					//caldersvg_log ( "not a file or readable: " . $filename );
					Logger::getLogger("default")->error ( "not a file or readable: " .$filename);
					continue;
				}
				
				$fullFileURL = $baseUrl .'/'. $folder.'/' . basename($filename);
				Logger::getLogger("default")->info ( $fullFileURL);
				
				$svgId = 'caldersvg-id-' . $idx;
				$svgDiv = '<div id="' . $svgId . '"></div>';
				$svgCanvas .= $svgDiv;
				
				$svgURLs [$svgId] = $fullFileURL;
				
				//caldersvg_log ( $svgCanvas );
				
				$idx += 1;
			}
			
			$script = '<script>';
			$script .= 'window.svgArray = ' . json_encode ( $svgURLs ) . ';';
			// $script .= 'launchTimer();';
			$script .= '</script>';
			// $svgCanvas .= '</svg>';
			$res = $svgCanvas . $script;
			
			Logger::getLogger("default")->info ( $res);
			return $res;
		}
		
		/*
		public function caldersvgjs_display_animation_fn($attributes) {
			//caldersvg_log ( '####### svgjs display_animation_fn #########' );
			// global $wp;
			$a = shortcode_atts ( array (
					'svgs' => '',
					'duration' => '1',
					'width' => '800',
					'height' => '600' 
			), $attributes );
			
			$svgFolder = $a ['svgs'];
			$duration = $a ['duration'];
			$width = $a ['width'];
			$height = $a ['height'];
			// $result = '<h2>' . 'SVG Story' . '</h2>';
			// $result .= 'SVG files:<br/>' . implode('<br/>', $filenames) . '<br/> Duration: ' . $duration;
			// $svgCanvas .= '<svg id="svgout" height="'.$height.'" width="'.$width.'">';
			
			$plugDir = plugin_dir_path ( __FILE__ );
			$plugURL = plugin_dir_url ( __FILE__ );
			// $plugDir = 'Plugin directory : ' . $dir;
			$svgDirectory = realpath ( $plugDir . $svgFolder );
			
			//caldersvg_log ( "build path " . $plugDir . $svgFolder );
			//caldersvg_log ( "became real path " . $svgDirectory );
			
			if (false === $svgDirectory) {
				//caldersvg_log ( "ERROR::directory does not exist " . $plugDir . $svgFolder );
			}
			
			$filenames = glob ( $svgDirectory . '/*.svg' );
			
			// //caldersvg_log($plugDir);
			//caldersvg_log ( count ( $filenames ) . " files retrieved in " . $svgDirectory );
		}
		*/
		function caldersvg_display_animation_fn($attributes) {
			//return "caldersvg_display_animation_fn";
			//error_log ("caldersvg_display_animation_fn" );
			//caldersvg_log ( '####### svg_s_display_animation_fn #########' );
			// global $wp;
			$a = shortcode_atts ( array (
					'svgs' => '',
					'duration' => '1',
					'width' => '800',
					'height' => '600' 
			), $attributes );
			
			Logger::getLogger("default")->debug ($a);
			$svgFolder = $a ['svgs'];
			$duration = $a ['duration'];
			$width = $a ['width'];
			$height = $a ['height'];
			Logger::getLogger("default")->debug ("SVGs path : ".$svgFolder);
			$homePath = ABSPATH;//get_home_path(__FILE__);
			Logger::getLogger("default")->debug ("Home path : ".$homePath);
			
			if (stripos($svgFolder,$homePath) === false) {
				//Logger::getLogger("default")->debug ($path);
				$absFolder = $homePath . $svgFolder;
				
			} else {
				$absFolder = $svgFolder;
				$svgFolder = str_replace($homePath,'',$svgFolder);
			}
			$svgDirectory = realpath ( $absFolder );
			if (false === $svgDirectory || !is_dir($svgDirectory)) {
				$msg = "directory does not exist " . $folder;
				//caldersvg_log ( "ERROR::directory does not exist " . $folder );
				Logger::getLogger("default")->error ($msg);
			
				return $msg;
			}			
			Logger::getLogger("default")->info ("abs: ".$svgDirectory);
			Logger::getLogger("default")->info ("rel: ".$svgFolder);
			
			$res = $this->load_svg_from_folder ( $svgDirectory, $svgFolder );
			//caldersvg_log ( $res );
			
			return $res;
		}
		function caldersvg_frontend_stylesheet() {
			$caldersvg_script_js = plugins_url ( '/js/caldersvg-frontend.js', __FILE__ );
			//caldersvg_log ( 'loading script ' . $caldersvg_script_js );
			
			wp_enqueue_script ( 'caldersvg-frontend-js', $caldersvg_script_js, array (
					'jquery' 
			) );
			// wp_localize_script( 'dental-office-frontend-js', 'doff_ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
			wp_enqueue_style ( 'caldersvg-css', plugins_url ( '/css/caldersvg.css', __FILE__ ) );
			
			$vivusVersion = "0.4.0";
			//caldersvg_log ( 'Vivus version ' . $vivusVersion );
			$vivus_script_js = plugins_url ( '/libs/vivus/' . $vivusVersion . '/vivus.min.js', __FILE__ );
			
			//caldersvg_log ( 'loading script ' . $vivus_script_js );
			wp_enqueue_script ( 'vivus-js', $vivus_script_js, array (
					'jquery' 
			) );
			
			$svgjsVersion = "2.5.0";
			//caldersvg_log ( 'SVG.js version ' . $svgjsVersion );
			$svgjs_script_js = plugins_url ( '/libs/svg.js/' . $svgjsVersion . '/svgjs.min.js', __FILE__ );
			
			//caldersvg_log ( 'loading script ' . $svgjs_script_js );
			wp_enqueue_script ( 'svgjs-js', $svgjs_script_js, array (
					'jquery' 
			) );
			
			// add anime.js
			$animeVersion = "2.0";
			//caldersvg_log ( 'anime version ' . $animeVersion );
			$anime_script_js = plugins_url ( '/libs/anime/' . $animeVersion . '/anime.min.js', __FILE__ );
			//caldersvg_log ( 'loading script ' . $anime_script_js );
			wp_enqueue_script ( 'anime-js', $anime_script_js, array (
					'jquery' 
			) );
		}
	}
}

new CalderSVG_FilesFetcher ();