=== Hyvor Talk - Comments, Newsletters, & Memberships ===
Contributors: hyvor, supunkavinda, nadil
Tags: comments, newsletter, memberships
Requires at least: 4.6
Tested up to: 6.6.1
Stable tag: 1.3.3
Requires PHP: 7.4
License: GPLv2
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Add comments, newsletters, and memberships to WordPress sites using Hyvor Talk.

== Description ==

[Hyvor Talk](https://talk.hyvor.com) is a privacy-first, fully-featured comments, newsletter, and memberships platform.

= Features =

== Comments ==

Hyvor Talk comes with a fully-featured, real-time commenting system that can replace the default WordPress commenting system.

* Real-time comments
* Upvotes & downvotes
* Reactions & ratings
* User badges
* Top-notch moderation tools
* In-build spam detection
* Upload images, GIFs
* Embed links, social media posts (Youtube, Facebook, X, etc.)
* Syntax highlighting
* Math (KaTeX) support

== Newsletter ==

You can use our Newsletter feature to easily add a newsletter subscription form to your website, collect emails,
and send newsletters to your subscribers.

* Newsletter subscription form with shortcode
* Send newsletters to your subscribers
* Track email opens and clicks
* Send emails from your own domain
* Customizable email templates
* Auto-subscribe users when signing up to WordPress

== Memberships ==

You can use our Memberships feature to convert your WordPress website into a memberships website.

* Create membership plans
* Set up Gated Content Rules to restrict content based on post types, categories, tags, and custom post types
* Restrict content based on membership plans
* In-website payments

== Developer-Friendly ==

Hyvor Talk is can be easily integrated into any website.

* [Console API](https://talk.hyvor.com/docs/api-console) for automation
* [Data API](https://talk.hyvor.com/docs/api-data) for public data access
* [Webhooks](https://talk.hyvor.com/docs/webhooks) for automation

WordPress-specific features:

* [Shortcodes](https://talk.hyvor.com/docs/wordpress#shortcodes)
* [Hooks](https://talk.hyvor.com/docs/wordpress#hooks) for customizing the plugin

== Other Features ==

* Fully customizable (colors, ui, and texts)
* Supports [30+ languages](https://talk.hyvor.com/docs/language#supported-languages)
* Usage analytics
* SEO-friendly
* GDPR compliant

= WordPress User Login =

You can turn on [Single Sign-on](https://talk.hyvor.com/docs/wordpress#sso) to connect WordPress authentication with Hyvor Talk. This will allow your users to use the embeds (comments, newsletter, memberships) using their account on your WordPress website.

= Importing Comments from WordPress =
You can import your WordPress comments to Hyvor Talk easily. Follow [this guide](https://talk.hyvor.com/docs/import) for more details. If you have previously used Disqus, you can also import comments from Disqus.

= Shortcodes =
* `[hyvor-talk-comments]` - Comments embed
* `[hyvor-talk-comments-count]` - Comments count
* `[hyvor-talk-newsletter]` - Newsletter embed
* `[hyvor-talk-gated-content]` - Gated content embed

See how to use shortcodes [here](https://talk.hyvor.com/docs/wordpress#shortcodes).

= Useful Links =

* [**WordPress Plugin Docs**](https://talk.hyvor.com/docs/wordpress)
* [**Hyvor Talk Console**](https://talk.hyvor.com/console) - This is where you manage your website.
* [**Pricing**](https://talk.hyvor.com/pricing)
* [**Docs**](https://talk.hyvor.com/docs)
* [**WordPress plugin on Github**](https://github.com/hyvor/hyvor-talk-wordpress-plugin)

= Blog Tutorials =

* [Add Paid Memberships and Gated Content to WordPress](https://hyvor.com/blog/wordpress-memberships)
* [Add a Newsletter Signup Form to WordPress](https://hyvor.com/blog/wordpress-newsletter-form)

== FAQ ==

= Is Hyvor Talk free? =

Hyvor Talk is a **paid service** with generous tiers for small websites. The WordPress plugin is free to install. After installing, connect it to your Hyvor Talk website, which you can create at [Hyvor Talk Console](https://talk.hyvor.com/console). See our [pricing](https://talk.hyvor.com/pricing) for more details. We offer a 14-day free trial.

= How can I get support? =

You can contact us via live chat on our website (https://talk.hyvor.com) or email us at [talk.support@hyvor.com](mailto:talk.support@hyvor.com). If you have an issue with the WordPress plugin, you can create an issue on [GitHub](https://github.com/hyvor/hyvor-talk-wordpress-plugin).

= What does "privacy-focused" mean? =

Integrating third-party JavaScript snippets into websites is common but can impact privacy by giving these services access to user data, which is often sold to advertisers. Our privacy-first approach is different: we don’t track, profile, or sell user data. We only collect minimal data needed for our service and charge a transparent fee, avoiding reliance on ads or data monetization.

= Where is data saved? =

Your website's data (comments, etc.) is saved in our secure servers located in Germany.

= What happens if I deactivate Hyvor Talk plugin on my website? =
You will no longer see the embeds on your website. You can reactivate the plugin at any time to get them back without losing any data.

= How can I customize the plugin? =

Our plugin itself is pluggable. It exposes multiple hooks that you can use to customize it. See [hooks docs](https://talk.hyvor.com/docs/wordpress#hooks) for more details.

== Installation ==

**Note:** First, you should register your website at Hyvor Talk. If you haven't done it yet, first visit the [console's add website section](https://talk.hyvor.com/console/account/add-website). Then, add your website and copy the **website ID**.

In the WordPress admin panel,

1. Go to **Plugins** > **Add New**
2. Type **hyvor talk** in the search box
3. Find **Comments by Hyvor Talk** by Hyvor
4. Click **Install Now**
5. Activate the plugin
6. Go to Hyvor Talk plugin
7. Add your website ID and click **Change**. (*You can find your website ID at the [console](https://talk.hyvor.com/console/general?action=choose-website).*)

== Screenshots ==

1. Hyvor Talk Console
2. Comments & Reactions Embed
3. Comments & Ratings Embed
4. Newsletter Form Embed
5. Memberships Embed

== Change Log ==

= 1.3.3 =
* Added `type="module"` to comment count script to avoid conflicts with other scripts

= 1.3.2 =
* Renamed `hyvor_talk_comment_counts_attributes` filter to `hyvor_talk_comment_count_attributes` for consistency
* Fixed the svelte styles conflicting issue

= 1.3.1 =
* Minor bug fixes

= 1.3.0 =
* Introduced Newsletters and Memberships
* Introduced Gated Content and Gated Content Rules
* Introduced a filter option to select which pages to load Comments Embed
* Introduced an option to change default page-id
* Introduced auto-subscribe on signup for Newsletter
* Introduced a filter option to select which pages to load Memberships Embed
* Introduced hyvor-talk-newsletter and hyvor-talk-gated-content shortcodes
* Introduced auto-configuration for admin secrets with Console API Key
* Introduced Webhooks

= 1.2.15 =
* Minor bug fix for hyvor-talk-comments-count

= 1.2.14 =
* Introducing new logo
* Minor bug fix in hyvor-talk-comments and hyvor-talk-comment-count shortcodes
* The modified code for the hyvor-talk-comment-count shortcode now automatically passes the post ID within a post if an ID is not set.

= 1.2.13 =
* V3 support made default
* V2 support revoked

= 1.2.8 =
* V3 beta support added

= 1.2.7 =
* Added support for Block-based themes

= 1.2.6 =
* New logo
* Introducing Shortcodes
* New websites (Website ID 5000+) uses post ID of WordPress to identify pages

= 1.2.2 =
* SSO ID removed
* SSO uses the user profile as the user's URL

= 1.2.1 =
* Custom identifiers added (To support third-party importing)

= 1.2.0 =
* SSO support added

= 1.1.2 =
* Bug fixed in comment count
* Multi language support added (Beta)

= 1.1.1 =
* Bug Fixed in the page

= 1.1 =
* Added comment counts support
* Added loading modes

= 1.0 =
* Introduced Hyvor Talk WordPress plugin.

== Upgrade Notice ==

= 1.2.6 =
We have fixed minor bugs and some accessibility in the dashboard, and a minor security bug. We recommend you to upgrade to the latest version.
