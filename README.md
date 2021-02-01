# palmate

A WordPress theme with integrations to Rosette.


## Installation

### WordPress

1. Install WordPress
1. Login to your WordPress installation.
1. Navigate to `Settings > General` and enter the following settings:
   - `Site Language` = `Svenska`
   - `Timezone` = `UTC+1`
   - `Date Format` = `Y-m-d`
   - `Time Format` = `H:i`
   - `Week Starts On` = `Monday`
1. Navigate to `Settings > Reading` and enter the following settings:
   - `Your homepage displays` = `A static page`, select your `Homepage`
1. Navigate to `Settings > Discussion` and enter the following settings:
   - `Default post settings` = Uncheck all
   - `Other comment settings` = Check `Users must be registered and logged in to comment`
1. Navigate to `Settings > Permalinks` and enter the following settings:
   - `Common settings` = Select `Post name`


### Blocksy Theme

Palmate is a child theme to [Blocksy](https://creativethemes.com/blocksy).
To be able to use Palmate you'll need to install Blocksy first.

1. Login to your WordPress installation.
1. Navigate to `Appearance > Themes` and click on the `Add new` button.
1. Search for `Blocksy`.
1. Click the `Install` button and then the `Activate` button.


### Palmate plugin

1. Copy the `palmate-admin-option` folder from https://github.com/LeafCoders/palmate/tree/master/wp-content/plugins to your WordPress installation at `wp-content/plugins`.
1. Login to your WordPress installation.
1. Navigate to `Plugins > Installed Plugins` and click `Activate` on `Palmate Admin Option`.
1. Navigate to `Settings > Palmate` (this menu was added by this plugin).
1. Enter the url to Rosette server.
1. Click the `Save` button.


### Palmate theme

1. Copy the `palmate` folder from https://github.com/LeafCoders/palmate/tree/master/wp-content/themes to your WordPress installation at `wp-content/themes`.
1. Login to your WordPress installation.
1. Navigate to `Appearance > Themes`.
1. Palmate theme should be listed here now (as well as the Blocksy theme).
1. Click the `Activate` button on Palmate theme.


## Development

### Update language files

Use the tool https://localise.biz/free/poeditor to enter Swedish translations for a php file.
