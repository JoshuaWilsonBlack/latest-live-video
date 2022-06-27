# Latest Live Video Plugin

The **Latest Live Video** Plugin is a very simple extension for [Grav CMS](http://github.com/getgrav/grav).
It uses the Facebook graph API to return the most recent live video from a page.
The plugin was developed for the Anglican Parish of
Saint Michael and All Angels. See the streaming module at the bottom of the
homepage [here](https://www.stmichaelandallangels.nz).

## Installation

Installing the Latest Live Video plugin can be done in one of three ways: The GPM (Grav Package Manager) installation method lets you quickly install the plugin with a simple terminal command, the manual method lets you do so via a zip file, and the admin method lets you do so via the Admin Plugin.

**Currently only manual installation works.**

### GPM Installation (Preferred)

To install the plugin via the [GPM](http://learn.getgrav.org/advanced/grav-gpm), through your system's terminal (also called the command line), navigate to the root of your Grav-installation, and enter:

    bin/gpm install latest-live-video

This will install the Latest Live Video plugin into your `/user/plugins`-directory within Grav. Its files can be found under `/your/site/grav/user/plugins/latest-live-video`.

### Manual Installation

To install the plugin manually, download the zip-version of this repository and unzip it under `/your/site/grav/user/plugins`. Then rename the folder to `latest-live-video`. You can find these files on [GitHub](https://github.com//grav-plugin-latest-live-video) or via [GetGrav.org](http://getgrav.org/downloads/plugins#extras).

You should now have all the plugin files under

    /your/site/grav/user/plugins/latest-live-video

> NOTE: This plugin is a modular component for Grav which may require other plugins to operate, please see its [blueprints.yaml-file on GitHub](https://github.com//grav-plugin-latest-live-video/blob/master/blueprints.yaml).

### Admin Plugin

If you use the Admin Plugin, you can install the plugin directly by browsing the `Plugins`-menu and clicking on the `Add` button.

## Configuration

Before configuring this plugin, you should copy the `user/plugins/latest-live-video/latest-live-video.yaml` to `user/config/plugins/latest-live-video.yaml` and only edit that copy.

Here is the default configuration and an explanation of available options:

```yaml
enabled: true
active_page: /streaming
page_id: # id of facebook page from which video will be taken.
page_access_id: # Long-lived page access token goes here.
text_var: Custom Text added by the **Latest Live Video** plugin (disable plugin to remove)
```

The `page_id` can be found using [these instructions](https://www.facebook.com/help/1503421039731588)
and `page_access_id` is obtained using [these instructions](https://developers.facebook.com/docs/facebook-login/guides/access-tokens/get-long-lived).
Ensure you don't make your long-lived (or indeed _any_) access token visible to users.

Note that if you use the Admin Plugin, a file with your configuration named latest-live-video.yaml will be saved in the `user/config/plugins/`-folder once the configuration is saved in the Admin.

## Usage

Once enabled, the most recent live video can be added to any template using
the following twig:
```html
{{ get_latest_video()|raw }}
```
