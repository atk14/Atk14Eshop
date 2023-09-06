User-agent: *
Disallow: /admin/*
Disallow: /api/*
Disallow: /recovery/*
Disallow: /obnova/*
Disallow: /*/baskets/add_card/*
{* According to https://developers.google.com/search/docs/crawling-indexing/qualify-outbound-links#nofollow *}
Disallow: {link_to controller="baskets" action="edit" _with_hostname=true}
Disallow: {link_to controller="favourite_products" action="index" _with_hostname=true}
Sitemap: {link_to controller="sitemaps" _with_hostname=true}
