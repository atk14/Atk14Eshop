{if $slider}

<div id="hp-slider" class="carousel slide hp-slider" data-ride="carousel">
    <style scoped="true">
        {foreach $slider->getItems() as $item}
        .carousel-item-{$item@iteration-1} .slider-image {
            background-image: url({$item->getImageUrl()|img_url:"1400x506"});
            color: white;
        }
        {/foreach}
    </style>
    <ol class="carousel-indicators">
        {foreach $slider->getItems() as $item}
            <li data-target="#hp-slider" data-slide-to="{$item@iteration-1}" class="{if $item@iteration==1}active{/if}"></li>
        {/foreach}
    </ol>
    <div class="carousel-inner">
        {foreach $slider->getItems() as $item}
        <div class="carousel-item carousel-item-{$item@iteration-1}{if $item@iteration==1} active{/if}">
            <div class="row">
                <div class="col-12 col-md-8 col-xl-9 slider-image">
                </div>
                <div class="col-12 col-md-4 col-xl-3 slider-text">
                    <h3>{$item->getTitle()}</h3>
                    <p>{!$item->getDescription()|h|nl2br}</p>
                    {if $item->getUrl()}
                      <a href="{$item->getUrl()}" class="">{t}more information{/t} <i class="fas fa-chevron-right"></i></a>
                    {/if}
                </div>
            </div>
        </div>
        {/foreach}
    </div>
    <a class="carousel-control-prev" href="#hp-slider" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"><i class="fas fa-chevron-circle-left"></i></span>
        <span class="sr-only">{t}Previous{/t}</span>
    </a>
    <a class="carousel-control-next" href="#hp-slider" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"><i class="fas fa-chevron-circle-right"></i></span>
        <span class="sr-only">{t}Next{/t}</span>
    </a>
</div>

{/if}
