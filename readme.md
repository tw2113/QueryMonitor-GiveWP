Query Monitor GiveWP
====================

Adds support for [GiveWP](https://givewp.com) information to the [Query Monitor](https://wordpress.org/plugins/query-monitor/) developer addon.

## Supports
* Defined GiveWP constants for a given request.
* Current true GiveWP conditional tags.
* Current meta data for a given request, if a form is found.
	* Single form view.
	* Embedded shortcode
	* Active GiveWP widget.

## Filters

* `qmgwp_constants`
	* Array of constants to output the current values for, if value set.

* `qmgwp_conditionals`
	* Array of conditional tags to check for a given request.
