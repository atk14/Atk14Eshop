{assign geometry_detail "1600"}
{assign geometry_thumbnail "x150"}
{assign geometry_preview "x450"}

{if !$gallery_variant}{assign gallery_variant "normal"}{/if}
{render partial="gallery/$gallery_variant"}
