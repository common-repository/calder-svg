=== Calder SVG ===
Contributors: munger41
Tags: animation, svg, art, calder
Requires at least: 4.0
Tested up to: 4.8
Stable tag: 1.7

Animate prepared SVG drawing as a mobile picture. 

== Description ==

Animate prepared SVG drawing as a mobile picture. Uses [Anime.js](http://anime-js.com/ "Anime.js") and [Vivus.js](https://maxwellito.github.io/vivus/ "Vivus.js")

Examples:

* [Musicians](http://caldersvg.termel.fr/ "Musicians")
* [Politicians](http://caldersvg.termel.fr/politicians/ "Politicians")

### Shortcode ###

Add desired prepared (see example) images in wordpress standard `uploads` folder (on multisite `uploads/sites/#/`), and add shortcode to any page, specifing svg folder to use and animate:

`[caldersvg svgs="wp-content/my/folder/containing/svg/files/"]`

or

`[caldersvg svgs="/var/www/mysite/wp-content/my/folder/containing/svg/files/"]`

with all your .svg files in last folder.

The `svgs` parameter DOES NOT contain a **URL** (starting by http://), but a **relative path** on the server.

You can test with default demo files, included inside plugin (under calder-svg/svg/), but you have to copy them under your uploads wordpress folder before, and use something like shortcode:

`[caldersvg svgs="../../svg/musicians/"]`

### SVG file example ###

If using Inkscape to create the SVG files, please save your files as Optimized SVG, then check that your file is containing a stroke and no fill for each path (else you could experience strange displays).
Like:

`fill="none" stroke-width="1" stroke="#cecece"`

`
<svg id="svg7876" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 571.25 650" version="1.1" xmlns:cc="http://creativecommons.org/ns#" xmlns:dc="http://purl.org/dc/elements/1.1/">
	<g id="g8426">
		<path id="path8440" fill="none" stroke-width="1" stroke="#cecece" d="m0 596.79c0-44.452 0.29402-53.508 1.7857-55 0.9822-0.99
`

== Installation ==

### Easy ###
1. Search Calder SVG via plugins > add new.
2. Find the plugin listed and click activate.
3. Use the Shortcodes

### Shortcode ###

Add desired prepared (see example) images in wordpress standard `uploads` folder (on multisite `uploads/sites/#/`), and add shortcode to any page, specifing svg folder to use and animate:

`[caldersvg svgs="wp-content/my/folder/containing/svg/files/"]`
or
`[caldersvg svgs="/var/www/mysite/wp-content/my/folder/containing/svg/files/"]`

with all your .svg files in last folder.

The `svgs` parameter DOES NOT contain a **URL** (starting by http://), but a **relative path** on the server.

You can test with default demo files, included inside plugin (under calder-svg/svg/), but you have to copy them under your uploads wordpress folder before, and use something like shortcode:
`[caldersvg svgs="../../svg/musicians/"]`

### SVG file example ###

If using Inkscape to create the SVG files, please save your files as Optimized SVG, then check that your file is containing a stroke and no fill for each path (else you could experience strange displays).
Like:
`fill="none" stroke-width="1" stroke="#cecece"`

`
<svg id="svg7876" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 571.25 650" version="1.1" xmlns:cc="http://creativecommons.org/ns#" xmlns:dc="http://purl.org/dc/elements/1.1/">
	<g id="g8426">
		<path id="path8440" fill="none" stroke-width="1" stroke="#cecece" d="m0 596.79c0-44.452 0.29402-53.508 1.7857-55 0.9822-0.99
`

### Examples ###

* [Musicians](http://caldersvg.termel.fr/ "Musicians")
* [Politicians](http://caldersvg.termel.fr/politicians/ "Politicians")

== Screenshots ==

1. Maria Callas
2. Bob Marley
3. Franz Liszt
4. Joe Cocker
5. Amy Winehouse
6. Wolfgang Amadeus Mozart
7. Rod Stewart

== Changelog ==

2.1 - bug fix

2.0 - complete refactor, be carrefully path changed in shortcode

1.7 - Vivus 0.4.0

1.6 - Animejs 2.0

1.3 - More explanations after feedback

1.0 - First stable release.