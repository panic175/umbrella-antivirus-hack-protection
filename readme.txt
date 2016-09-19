=== Site Protection by Umbrella Plugins ===
Contributors: rkjellberg
Tags: antivirus, site protection, vulnerabilities, core scanner, database, backup, database backup, protection, firewall, vulnerability, vulnerabilities, scanner, file, hide versions, disable pings, captcha, captcha login, secure login, umbrella plugins, block, requests, virusskydd, virus skydd
Keywords: antivirus, site protection, vulnerabilities, core scanner, database, backup, database backup, protection, firewall, vulnerability, vulnerabilities, scanner, file, hide versions, disable pings, captcha, captcha login, secure login, umbrella plugins, block, requests, virusskydd, virus skydd
Requires at least: 3.7
Tested up to: 4.3
Stable tag: 1.8.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

With features as vulnerability scanner, core scanner, block suspicious requests, hide versions, disable pings, captcha login and more.

== Description ==

Umbrella helps you protect your WordPress site and checks your plugin and themes for known vulnerabilities. More functions are planned and will be launched soon. Please look for updates :)

= Major features in Umbrella include =
* Vulnerabilities scanner for themes and plugins. 
* Add CAPTCHA to login screen for a more secure login. 
* Block all unauthorized and irrelevant requests through query strings.
* Hide version numbers in your front-end source code for WordPress-core and all of your plugins. 
* Completely turn off trackbacks & pingbacks to your site.
* Scan WordPress for unknown files and file modifications by comparing md5 strings.
* Disable Themes & Plugins-editor.
* CloudFlare Support

= Planned features =
* Scan files and folders for permission issues.
* Umbrella Network: Mange all of your sites from one place.
* In-app feedback and live chat support.
* More CloudFlare options trough CloudFlare API.

== Installation ==

1. Upload the entire `umbrella-antivirus-hack-protection` folder to the `/wp-content/plugins/` directory or download it from Plugins in WordPress Dashboard.
2. Activate the plugin through the 'Plugins' menu in WordPress.

You will find the 'Site Protection' tab in your WordPress admin panel.

== Screenshots ==

1. Manage all settings in Dashboard
2. Scan for plugins and themes vulnerabilities
3. Scan for modifications in core files
4. Log all hacking attempts and warnings
5. Compare modifications in core files.

== Changelog ==

= 1.8.4 =
*Release Date - 19 sept 2015*

* Bugfix: Version comparison bug (https://wordpress.org/support/topic/version-comparison-bug)

= 1.8.3 =
*Release Date - 19 sept 2015*

* Update for WordPress Core 4.3.1

= 1.8.2 =
*Release Date - 31 aug 2015*

* Major bugfixes
* PHP Code Optimization - Site Protection is now faster then before!
* target="_blank" on outgoing vulnerability explanation links

= 1.8.1 =
*Release Date - 29 aug, 2015*

* Bugfix for external servers in Database Backup

= 1.8 =
*Release Date - 29 aug, 2015*

* Added support for Database Backup
* Testing new navigation labels
* Fixed some CSS bugs.
* Added swedish translation

= 1.7.1 =
*Release Date - 22 aug, 2015*

* Update for WordPress Core 4.3

= 1.7 =
*Release Date - 15 aug, 2015*

* Update for WordPress Core 4.2.4

= 1.6 =
*Release Date - 1 june, 2015*

* Pagination for log entries
* Sort log entries by IP
* More specific data for log entries (Toggle Advanced Details)
* Major warning fixes
* Fixing CAPTCHA error when GD & FreeType PHP modules are not installed.
* Update for WordPress Core 4.2.3

= 1.5.1 =
*Release Date - 19 may, 2015*

* Update for WordPress Core 4.2.2

= 1.5 =
*Release Date - 28 April, 2015*

* Update for WordPress Core 4.2.1
* Released a new version of the core scanner
* Compare modified files against WordPress svn-repository
* Enabled PRO upgrades
* Bugfix: Captcha login didn't work on some sites
* Bugfix: Return "Unkown" instead of error when connection is broken
* Email subscription form
* Compressed image files
* Temporary removed swedish language (it will be back)
* New screenshots
* Changed all post request to WordPress ajax
* Free BETA license key for users using this version.

= 1.4.4 =
*Release Date - 24 April, 2015*
 
* Core files list database for WordPress 4.2

= 1.4.3 =
*Release Date - 20 April, 2015*
 
* Core files list database for WordPress 4.1.2

= 1.4.2 =
*Release Date - 20 April, 2015*
 
* Update for WordPress 4.2
* Bugfix: Conflict when using Captcha login together with the Really Simple Captcha plugin.
* Real Time Updates: Check for plugin updates each 10 minutes instead of each 12 hours.
* Added new versions to core scanner db: 4.1.2-alpha, 4.2-RC1, 4.2-RC2

= 1.4.1 =
*Release Date - 19 April, 2015*
 
* Enable/Disable Automatic Updates for Umbrella Site Protection.
* Admin notice on plugin updates.
* Layout: New header in option pages.
* New assets for plugin pages.

= 1.4 = 
*Release Date - 18 April, 2015*

* New layout for option pages.
* Plugin changed name to Umbrella Site Protection and authors updated.
* File scanner changed name to core scanner and is now much faster than before.
* New features: Disable Themes & Plugins-editor.
* More patterns added to the Filter Request module for better security..
* It's now possible to ignore trustable files in core scanner.
* Included Really Simple Captcha plugin as library.
* Show visitors ip address in log messages.
* Admin Notices on new log entries.

= 1.3 =
*Release Date - 15 March, 2015*

* Bugfix: Filter Requests blocked some post updates
* Google Safe Browsing Checker
* Hosting Status in Dashboard
* Widgets in Dashboard
* Log all suspicious traffic for later analysation
* Updated language swedish (sv_SE)
* Cload Flare checker

= 1.2 =
*Release Date - 7 March, 2015*

* BETA version of File Scanner
* Bugfix: Undefined property: stdClass::$url when vulnerability has no external URLs.
* Translation to swedish (sv_SE)

= 1.1 =
*Release Date - 1 March, 2015*

* Vulnerabilities scanner for themes and plugins. 
* Add CAPTCHA to login screen for a more secure login.

== Frequently Asked Questions ==
= Does this protect my site from hackers? =
Yes. 