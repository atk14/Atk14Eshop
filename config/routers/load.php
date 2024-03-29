<?php
// Here is a place for the list of application routers

// When one has a router for making nice human readable URLs to articles,
// the router should be listed here:
//
//  Atk14Url::AddRouter("ArticlesRouter");
//  Atk14Url::AddRouter("blog","ArticlesRouter"); // adding the same ArticlesRouter to a namespace blog

Atk14Url::AddRouter("PagesRouter");
Atk14Url::AddRouter("ArticlesRouter");
Atk14Url::AddRouter("MarkdownManualRouter");
Atk14Url::AddRouter("StyleguidesRouter");

// Catalog specific routers
Atk14Url::AddRouter("CardsRouter");
Atk14Url::AddRouter("CategoriesRouter");
Atk14Url::AddRouter("BrandsRouter");
//Atk14Url::AddRouter("CollectionsRouter"); // Collections are obsolete in Atk14Eshop
Atk14Url::AddRouter("StoresRouter");

Atk14Url::AddRouter("DigitalContentsRouter");

Atk14Url::AddRouter("AdminRouter");

Atk14Url::AddRouter("CookieConsentsRouter");

// Keep the DefaultRouter at the end of the list
Atk14Url::AddRouter("DefaultRouter");
