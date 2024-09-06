=== Comments by Hyvor Talk ===
Contributors: hyvor, supunkavinda, nadil
Tags: comments, commenting system, commenting platform, commenting plugin
Requires at least: 4.6
Tested up to: 6.6.1
Stable tag: 1.2.16
Requires PHP: 7.4
License: GPLv2
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Add comments, newsletters and memberships to WordPress sites using Hyvor Talk.

== Description ==

[Hyvor Talk](https://talk.hyvor.com) is a privacy-first, fully-featured commenting, newsletters and memberships system for websites.

= Features =

* Real-time comments
* Upvotes and downvotes
* Reactions
* Fully customizable (colors, ui, and texts)
* Supports [24+ languages](https://talk.hyvor.com/docs/language#supportedlanguages)
* SEO-friendly
* Powerful [moderation tools](https://talk.hyvor.com/docs/moderating-comments) (banning, shadow banning, etc.)
* User badges
* Automatic spam detection
* Comment analytics
* Upload images, post GIFs, and markdown support
* Emojis
* Auto code highlighting.
* Newsletter form
* Auto-subscribe on signup
* Memberships and Gated Content
* Gated Content Rules
* Custom page selection for comments and memberships embeds
* Defaul page-id selection
* Webhooks
* Filters for advanced customization

= WordPress User Login =
You can turn on [Single Sign-on (Stateless)](https://talk.hyvor.com/docs/sso) to allow your WordPress users to comment without having a Hyvor account.

= Importing Comments from WordPress =
You can import your WordPress comments to Hyvor Talk easily. Follow [this guide](https://talk.hyvor.com/docs/import-wordpress) for more details. If you have previously used Disqus, you can [import Disqus comments](https://talk.hyvor.com/docs/import-disqus) too.

= Shortcodes =
* `[hyvor-talk-comments]` - Comments embed
* `[hyvor-talk-comments-count]` - Comments count
* `[hyvor-talk-newsletter]` - Newsletter embed
* `[hyvor-talk-gated-content]` - Gated content embed

See how to use shortcodes [here](https://talk.hyvor.com/docs/wordpress#shortcodes).

= Useful Links =

* [**Hyvor Talk Console**](https://talk.hyvor.com/console)
* [**Plans & Pricing**](https://talk.hyvor.com/plans)
* [**Docs**](https://talk.hyvor.com/docs)
* [**WordPress Plugin Guide in Docs**](https://talk.hyvor.com/docs/wordpress)

== FAQ ==

= Does Hyvor Talk show ads on my website? =

No. Hyvor Talk is ad-free and privacy-focused. We do not place any ads on your website. We do not track your users. We do not sell your data to any third-party. Privacy by design!

= Where are comments saved? =

Comments are saved on our databases. You can export comments anytime. However, syncing comments with your WordPress database is not yet available.

= What happens if I deactivate Hyvor Talk plugin on my website? =
You won't see comments plugin anymore on your website. But, you can add it anytime again. Then, you will see your earlier comments.

= Can I manually install Hyvor Talk on WordPress? =

Yes, you can use [shortcodes](https://talk.hyvor.com/docs/wordpress#shortcodes) to install Hyvor Talk manually on your theme.

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
