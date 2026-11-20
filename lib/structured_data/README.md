# Structured Data

Schema.org JSON-LD markup for Google Search rich results, rendered as `<script type="application/ld+json">` tags at the end of `<body>`.

## Architecture

**`Collector`** is a request-scoped singleton (`Collector::GetInstance($controller)`) that accumulates structured data items for the current page. The layout iterates over `$structured_data->toArray()` and renders one `<script>` tag per item.

**Elements** (`element/*.php`) extend `BaseElement` and implement a single `toArray()` method returning the Schema.org array, or `null` if the element has nothing to output (e.g. `Offer` without a price). Available elements:

| Class | Schema.org type | Typical usage |
|---|---|---|
| `Article` | `Article` | Article detail page |
| `Product` | `Product` | Card detail page |
| `Offer` | `Offer` | Single-variant card |
| `AggregateOffer` | `AggregateOffer` | Multi-variant card |
| `AggregateRating` | `AggregateRating` | Embedded inside `Product` |
| `BreadcrumbList` | `BreadcrumbList` | Any page with breadcrumbs |
| `BreadcrumbListItem` | `ListItem` | Individual breadcrumb, used by `BreadcrumbList` |
| `ImageObject` | `ImageObject` | Standalone images, galleries |
| `VideoObject` | `VideoObject` | Video detail pages |

**Adding structured data in a controller:**

```php
use StructuredData\Element\Article as ArticleStructuredData;

$this->structured_data->addItem(new ArticleStructuredData($article));
```

**Adding a new element** — create `lib/structured_data/element/my_type.php`:

```php
namespace StructuredData\Element;

class MyType extends \StructuredData\BaseElement {
    function __construct(\MyModel $item, $options=[]) {
        $this->item = $item;
        $this->options = $options;
    }

    function toArray() {
        return [
            "@context" => "https://schema.org",
            "@type"    => "MyType",
            "name"     => $this->item->getName(),
        ];
    }
}
```

## Google Search support — Czech market

| Type | CZ support | Notes |
|---|---|---|
| `Article` | ✅ full | No limitations |
| `Product` + `Offer` | ✅ partial | Pros & Cons feature not available for CZ; shopping carousel being tested |
| `AggregateRating` | ✅ full | No limitations |
| `BreadcrumbList` | ✅ full | Desktop only since 2025 (Google removed mobile breadcrumbs) |
| `ImageObject` | ✅ full | No limitations |
| `VideoObject` | ✅ partial | `SeekToAction` (automated key moments) not supported for CZ; use `Clip` (manual key moments) instead |
| `WebSite` / `SearchAction` | ❌ | Deprecated November 2024 — has no effect, do not use |

Sources:
- https://developers.google.com/search/docs/appearance/structured-data/search-gallery
- https://developers.google.com/search/blog/2024/10/sitelinks-search-box
- https://developers.google.com/search/blog/2025/01/simplifying-breadcrumbs
