=== BuddyPress Registration Groups ===
Plugin URI: http://hardlyneutral.com/wordpress-plugins/
Version: 0.8
Tags: buddypress, groups, registration, autojoin
Requires at least: WordPress 3.2.1 / BuddyPress 1.5
Tested up to: WordPress 3.2.1 / BuddyPress 1.5
License: GNU/GPL 2
Author: Eric Johnson
Author URI: http://hardlyneutral.com/wordpress-plugins/
Contributors: hardlyneutral
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=TYJT5VMV8YMVQ
Stable tag: trunk

WordPress/WordPress MU and BuddyPress. Allows a new user to select groups to join during the registration process.

== Description ==

This plugin is built to display BuddyPress groups on the new user registration page in a list where the user can
select, via checkbox, which groups they would like to join immediately. Only Public groups are shown;
no Private or Hidden groups will be available. The selected group's IDs are stored in the following locations:

* usermeta table - for WordPress/BuddyPress installations
* meta field of signups table - for WP3/BuddyPress or WPMU/BuddyPress installations

== Installation ==

The plugin is packaged so that you can use the built in plugin installer in the WordPress admin section. Just select the
.zip file and install away! Activate the plugin once it is installed.

If you would like to install manually:

1. Extract the .zip file
2. Upload the extracted directory and all its contents to the '/wp-content/plugins/' directory
3. Activate the plugin throught the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= What if the plugin doesn't work? =

Hit me up on my website and let me know. I only do this in my spare time, so don't expect a super quick response :)

== Screenshots ==
1. Screenshot of the plugin listing three groups on the new user registration page.

== Changelog ==

= 0.8 =
* Validated plugin is compatible with BuddyPress 1.5
* Modified plugin listing to remove 20 group limit; limit is now 99999

= 0.7 =
* Validated plugin is compatible with WordPress 3.2.1 and BuddyPress 1.2.9
* Changed default group listing to only show public groups, hidden and private groups are not shown

= 0.6 =
* Fixed a bug where the timeline would not record group names correctly on join
* There is a known issue with user avatars not displaying in the timeline when joining on registration, plugin works fine otherwise

= 0.5 =
* Changed group ordering on the registration page to alphabetical

= 0.4 =
* Replaced static link to plugin .css file with a dynamic one
* Addressed minor styling issue
* Addressed error that was being thrown if no groups were selected

= 0.3 =
* Tested as functional on WordPress 3.0 and BuddyPress 1.2.5.2
* Tested as functional in both WP3 single and multisite installations

= 0.2 =
* Updated plugin to work in single and multiuser environments
* Tested as functional on WordPress 2.9.2 and BuddyPress 1.2.5.2
* Tested as functional on WordPress MU 2.9.2 and BuddyPress 1.2.5.2
* Added a readme.txt
* Added loader.php to prevent plugin from loading if BuddyPress is not active
* Added includes directory
* Moved bp-registration-groups.php to includes directory
* Added plugin specific CSS file to includes directory
* Added code to only load CSS on the registration page

= 0.1 =
* First version!

== Upgrade Notice ==

= 0.8 =
This version addresses an issue with only showing 20 groups on the registration page. See Changelog for details.

= 0.3 =
This version addresses several functionality issues. Upgrade immediately.

= 0.4 =
This version addresses a minor styling issue and an error shown on user activation if no groups were selected during registration. Upgrade immediately.

= 0.5 =
This version changes the display order of groups on the registration page to alphabetical.

= 0.6 =
This version addresses an issue with group names not displaying correctly in the timeline. Upgrade immediately.