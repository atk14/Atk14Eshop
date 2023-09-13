User-agent: *
Disallow: /admin/*
Disallow: /api/*
Disallow: /recovery/*
Disallow: /obnova/*
Disallow: /*/favourite_products/create_new/*
Disallow: /*/baskets/add_card/*
{* According to https://developers.google.com/search/docs/crawling-indexing/qualify-outbound-links#nofollow *}
{**
 * Crawler does not visit urls that start with path in Disallow. Wildcard * is not needed.
 *
 * @see https://developers.google.com/search/docs/crawling-indexing/robots/robots_txt#url-matching-based-on-path-values
 *}
Disallow: {link_to controller="baskets" action="index" _with_hostname=true}
Disallow: {link_to controller="favourite_products" action="index" _with_hostname=true}
Disallow: {link_to controller="watched_products" action="index" _with_hostname=true}
Sitemap: {link_to controller="sitemaps" _with_hostname=true}
