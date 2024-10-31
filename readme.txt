=== RSS Base ===
Contributors: thysell
Tags: posts, rss, url
Requires at least: 2.0.2
Tested up to: 2.5
Stable tag: 1.1.1

Make relative URLs absolute, in order to fix RSS feeds.

== Description ==

RSS Base will rewrite all relative link and image tags (`<a>` and `<img>`) to include a base URL.

RSS feeds require absolute URLs to both validate and function properly.

Feed readers can become confused when seeing relative paths, because they won’t necessarily know what base URL to use. A suggested [update to the RSS standard](http://cyber.law.harvard.edu/rss/relativeURI.html "") has not been widely adopted.

This plugin uses code from [Gerd Riesselmann](http://www.gerd-riesselmann.net/archives/2005/11/rss-doesnt-know-a-base-url/ "RSS doesn't know a base-URL")

== Installation ==

1. Upload `rss-base.php` to your `/wp-content/plugins/` directory.
1. Activate RSS Base through the 'Plugins' menu in WordPress.
1. Go to the "RSS Base" options page and set your base URL.

== Frequently Asked Questions ==

= Is a post's permalink used when determining the absolute URL? =

No, currently this plugin only finds every relative link in posts and comments, and prefixes those links with the base URL you choose in your options.
