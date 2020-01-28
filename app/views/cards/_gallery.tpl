{assign geometry_detail "2000x1600"}
{assign geometry_thumbnail "x150"}
{assign geometry_preview "x600"}

{if !$gallery_variant}{assign gallery_variant "normal"}{/if}
{render partial="gallery/$gallery_variant"}
