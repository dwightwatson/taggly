<?php
return [

	/**
	*
	* set max an min font size
	* default:
	*    min: 12
	*    max: 24
	*
	*
	*/
	'font_size' => [

		'max' => null,
		'min' => null,

		/**
		 *
		 * or you can use class to
		 * set size of the childs+
		 *
		 * if you set class font.max, font.min and
		 * font_unit are ignore
		 *
		 *	Example:
		 *
		 * 	'class' => [
		 *
		 * 		'0' => 'tag-1',
		 * 		'1' => 'tag-2',
		 * 		'2' => 'tag-3',
		 * 		'3' => 'tag-4',
		 * 		'4' => 'tag-5',
		 * 	]
		 *
		*/
	],

	/**
	*
	* font size unit
	*    css: px, em, %
	* default: px
	*
	*/

	'font_unit' => '',

	/**
	*
	* Add Spaces after a Tag
	* default: false
	*
	**/

	'add_spaces' => null,

	/**
	*
	* shuffle tags before output
	* default: true
	*
	**/

	'shuffle_tags' => null,

	/**
	 *
	 * set HTML Tags & class
	 *
	 */

	'html_tags' => [
    	'parent' => [
    		'name' => 'div',
    		'attributes' => [
    			'class' => 'tags'
    		]
    	],
    	'child' => []
	],

];

?>
