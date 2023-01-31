<div class="card__icons">
  {if $favourite_products_accessor->isFavouriteCard($card)}
    <span class="card-icon card-icon--favourite" title="{t}Your favourite product{/t}">{!"heart"|icon}</span>
  {/if}
</div>