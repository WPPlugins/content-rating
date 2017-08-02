=== Content Rating ===
Contributors: miqrogroove
Tags: content, rating, label, labels, labelling, RSAC, RSACi, ICRA, PICS, RDF, POWDER, SafeSurf, RTA, restricted, parental, control, controls, adult
Requires at least: 2.7
Tested up to: 3.1.3
Stable tag: 1.1.02

Rate and label your posts to enable parental control.

== Description ==

Resolves the challenge of labeling your dynamic content.

For starters, you can enable one or more rating systems and then create a set of "labels".  These labels can then be applied to individual posts.  A default label can be used also, so that it is not necessary to edit every post.

This plugin automatically evaluates the labels for your dynamic pages, such as the front page, categories, and tags.  Labels are dynamically generated so that a "Loop" type page receives the cumulative rating of the posts being displayed.

Attachment pages can also be labeled.  For convenience, any unrated attachment will receive the label(s) of the post it is attached to, and will also fall back to the default label(s) if the post is unrated.

All of these systems are included:

* ICRA 2008
* ICRAv03
* ICRAv03/PICS
* ICRAv02
* RSACi
* RTA
* SafeSurf

= Requirements and Limitations =

This plugin absolutely requires PHP 5.1 or higher.  Appropriate errors will be displayed on inadequate servers.

WordPress 2.8 or higher is recommended, although 2.7 should be compatible.

This system does not make labels for static content such as image files, which are not served by WordPress.

== Installation ==

1. Upload the `content-rating` directory to your `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress

This plugin provides a "Settings" link on the Plugins screen, as well as a "Content Rating" link on the Posts menu.  Clicking these links will bring you to the Content Rating Systems screen, where you can enable one or more of the provided labeling systems.

After enabling the system(s) of your choice, you may then proceed to add new labels from the Content Rating screen.

Deactivating this plugin does not delete any saved data.  However, there is an "uninstall" utility for this plugin that is activated automatically if you click the Delete link on the Plugins screen.  Using the Delete link therefore erases all saved data including settings, content labels, label records, and label files.

== Frequently Asked Questions ==

= IE says "This page does not have a rating." =

There are two known flaws in the Content Advisor for Internet Explorer.

1. A 256-byte buffer length is used to read the PICS-Label HTTP header.  If you enable several rating systems in the Content Rating plugin, Internet Explorer will not see a valid PICS-Label header in HTTP Only mode.
1. Certain items preceeding the PICS meta element in the HTML head will break Content Advisor.  Check your page source code and ensure that the PICS-Label meta element is appearing as early as possible in the HTML head.

== Changelog ==

= future version =

Authors should be able to rate own posts only.

= 1.1.01 =
* New features, released 11 June 2011.
* Added HTML output options in addition to the original HTTP Only mode.
* Now compatible with WP Super Cache when using HTML Only mode or HTTP & HTML mode.
* Added a system module for the RTA (Restricted to Adults) label.
* WordPress 3.1.3 tested.

= 1.0.14 =
* New features, 20 March 2010.
* Added post listing for each label, linked to label's "Count".
* Post "Label" links now turn on only after a module is enabled.
* Removed max version limit.  WordPress 3.0-alpha tested.

= 1.0.10 =
* Version number bumped for clairty on the .org Extend page, 10 March 2010.

= 1.0.09 =
* Bug fixes 9 March 2010.

= 1.0.00 =
* First version, released 8 March 2010.
