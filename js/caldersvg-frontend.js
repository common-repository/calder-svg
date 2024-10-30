jQuery(document).ready(
	function($) {

	    console.log("jquery document ready");

	    function vivusAnimOnReady() {
		console.log("vivusAnimOnReady");
		/*
		 * $svgId = 'caldersvg-id-' + window.svgAnimateIterator; $("#" +
		 * $svgId).fadeIn(3000);
		 * 
		 * console.log("Show " + "#" + $svgId);
		 */
	    }

	    function timerTick() {
		if (typeof window.svgArray === 'undefined'
			|| window.svgArray == null) {
		    return;
		}
		console.log("Timer tick " + window.svgAnimateIterator);

		$svgId = 'caldersvg-id-' + window.svgAnimateIterator;
		$url = window.svgArray[$svgId];

		Object.keys(window.svgArray).forEach(function(arrayItem) {
		    // console.log("Hide " + "#" + arrayItem);

		    /*
		     * var node = document.getElementById(arrayItem); var
		     * childNodes = node.childNodes; console.log(childNodes);
		     * 
		     * for (var i = 0, len = childNodes.length; i < len; i++) {
		     * //someFn(arr[i]);
		     * 
		     * console.log("fading last child"); var id =
		     * childNodes[i].getAttribute("id"); console.log(id);
		     * //node.lastChild.hide(1000); $('#' + id).fadeOut("slow",
		     * function() { // Animation complete. console.log("removing
		     * last child"); console.log(childNodes[i]);
		     * //node.removeChild(childNodes[i]); }); }
		     */

		    /*
		     * while (node.hasChildNodes()) { //node.fadeOut();
		     * //node.lastChild.fadeOut(); }
		     */
		    if (arrayItem != $svgId) {

			// console.log("--- fadeout "+arrayItem);
			// console.log(arrayItem);
			$('#' + arrayItem).fadeOut(1000);
		    } else {
			// console.log("+++ keeping node " + arrayItem);
			// $svgId = 'caldersvg-id-' + window.svgAnimateIterator;
			$("#" + arrayItem).fadeIn(2000);

			console.log("Show " + "#" + $svgId);
		    }

		});

		var nbOfSVG = Object.keys(window.svgArray).length;
		console.log(window.svgAnimateIterator + "/" + nbOfSVG);

		var types = [ 'delayed', 'async'/* , 'oneByOne' */];
		var animType = types[Math.floor(Math.random() * types.length)];
	
		var timingFunction = Vivus.EASE_IN;

		var pathTimingFunc = Vivus.EASE_IN;

		var animDuration = 250;
		console.log($url);
		console.log('#' + $svgId);
		var previousSvg = $('#' + $svgId).empty();
		/*console.log(previousSvg);
		if (previousSvg) {
		    console.log("restart previous");
		    $("#foo").empty();
		    while (previousSvg.firstChild) {
			console.log("remove : "+previousSvg.firstChild);
			previousSvg.removeChild(previousSvg.firstChild);
			}
		  
		}*/
		var newVivusObj = new Vivus($svgId, {
		    onReady : vivusAnimOnReady(),
		    type : animType,
		    // duration : animDuration,
		    start : 'autostart',
		    delay : 10, // seulement pour le type "delayed"
		    selfDestroy : true,
		    file : $url,
		    animTimingFunction : timingFunction,
		    pathTimingFunction : pathTimingFunc,
		}, function(myVivus) {
		    console.log("callback " + $svgId);

		    var pathAnim = anime({
			targets : 'path',
			translateX : function(target) {
			    var booly = anime.random(0, 1);
			    if (booly) {
				return anime.random(-40, 40);
			    } else {
				return 0;
			    }

			},
			translateY : function(target) {
			    var booly = anime.random(0, 1);
			    if (booly) {
				return anime.random(-40, 40);
			    } else {
				return 0;
			    }

			},
			/*
			 * opacity: { value: [0.2, 0.9], duration: 100, },
			 */

			/*
			 * opacity: { value: [0.2, 0.9],//anime.random(0.2,
			 * 0.9), duration: 100, },
			 */
		    
			opacity : function(target) {
			    var res = anime.random(0.4, 0.9);
			    return res;
			},

			backgroundColor : function(target) {
			    // console.log(target);
			    // console.log(target.getAttribute("stroke"));
			    var booly = anime.random(-1, 1);
			    if (booly > 0) {
				target.setAttribute("fill", target
					.getAttribute("stroke"));
				return target.getAttribute("stroke");
			    } else {
				return "none";
			    }
			},

			
			// opacity: 1,
			// easing: "easeOutSine",

			delay : function(t, i) {
			    return 0 + (i * 90)
			},
			// duration : 1000,
			// loop : 2,
			direction : 'alternate',
			// speed : 1,
			complete : function() {
			    console.log("complete " + $svgId);
			    // myVivus.destroy();
			    
			    launchTimer(false);
			   // destroy();
			},
		    });	
		
		});
		//}
	    }

	    function launchTimer(firstValue) {
		if (typeof window.svgArray === 'undefined'
			|| window.svgArray == null) {
		    return;
		}

		var nbOfSVG = Object.keys(window.svgArray).length;

		if ($.isNumeric(firstValue)) {
		    window.svgAnimateIterator = firstValue;
		} else {
		    window.svgAnimateIterator++;
		    if (window.svgAnimateIterator >= nbOfSVG) {
			window.svgAnimateIterator = 0;
		    }
		}

		timerTick();
	    }

	    function getRandomInt(min, max) {
		return Math.floor(Math.random() * (max - min + 1)) + min;
	    }

	    function buildVivusObjects() {
		console.log("########## BUILDING VIVUS OBJECTS ############");
		console.log(window.svgArray);
		var nbOfSVG = Object.keys(window.svgArray).length;
		window.vivusObjects = [];
		for (var i = 0; i < nbOfSVG; i++) {

		    $svgId = 'caldersvg-id-' + i;
		    $url = window.svgArray[$svgId];

		    console.log(i + ' / ' + nbOfSVG + ' :: ' + $svgId + ' :: '
			    + $url);

		}

		console.log("All objects built");
		console.log(window.vivusObjects);

	    }

	    launchTimer(0);

	});