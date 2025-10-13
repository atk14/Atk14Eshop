Offcanvas component
===================

Offcanvas sidebar useful for navigation. ATK14Eshop shopping cart preview is built with this component.

Offcanvas can be opened by clicking element with <code>data-toggle="offcanvas"</code> attribute with <code>data-target</code> or <code>href</code> which specifies target offcanvas element (<code>data-target</code> has higher priority). Offcanvas content is scrollable if it is longer than available height.

Markup for this component is derived form Bootstrap 5 Offcanvas Component for future compatibility.

## Basic example, opens on right

[example]
  <a href="#offcanvas-demo-basic" class="btn btn-primary" data-toggle="offcanvas" aria-expanded="false" aria-controls="offcanvas-demo-basic" >Link with href</a>
  <button class="btn btn-primary" data-toggle="offcanvas" data-target="#offcanvas-demo-basic" aria-expanded="false" aria-controls="offcanvas-demo-basic" >Button with data-target attribute</button>

  <div id="offcanvas-demo-basic" class="bs-offcanvas bs-offcanvas-right bg-light">
    <header class="bs-offcanvas-header bs-offcanvas-header--fixed-top">
      <button type="button" class="bs-offcanvas-close close" aria-label="Close" aria-expanded="false"><span class="fas fa-xmark"></span></button>
      <h4 class="bs-offcanvas-title">Offcanvas Title</h4>
    </header>
    <div class="bs-offcanvas-content p-2">
      Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus maximus scelerisque lobortis. Nam tincidunt nunc neque, vel mollis enim pellentesque vel. Mauris a lectus fermentum, tempus justo sit amet, congue nunc. Sed eu odio id purus pulvinar interdum. Sed erat magna, viverra eu maximus euismod, posuere non arcu. Pellentesque euismod enim sit amet nibh efficitur tristique. Duis porttitor lectus non convallis dictum. Vestibulum id convallis diam. Ut ut semper arcu. Maecenas tincidunt ultricies ultrices. Nunc urna tortor, hendrerit in facilisis ac, pellentesque nec eros. Integer a accumsan tellus. 
      Integer vel nunc sit amet massa fermentum mattis nec ac metus. Cras vitae metus nec ipsum molestie mollis. Suspendisse eget purus a orci dictum lacinia ac eu purus. Ut nunc libero, tincidunt ac venenatis at, iaculis a magna. Aenean metus augue, varius et tempus efficitur, cursus maximus diam. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam vulputate lacus odio. Phasellus gravida pretium justo hendrerit ullamcorper. Donec sed nisl quis ipsum porttitor elementum vitae in arcu. In iaculis, turpis quis dapibus scelerisque, magna nunc ornare felis, ut tristique quam leo quis felis. Fusce dictum, nunc quis ultrices cursus, lacus quam vehicula risus, a mollis arcu lorem eget lectus. Suspendisse leo sapien, efficitur id purus a, porttitor venenatis lorem. Quisque erat nulla, viverra eget rhoncus et, pretium quis nunc. Etiam rutrum ultricies mi a pretium. 
    </div>    
  </div>
[/example]

## Offcanvas basket

Offcanvas component actiing as ofcanvas basket. Items list is scrollable when it exceeds available height. After exceeding certain number of items they are displayed in more compact form to avoid too tall list. See [Shopping Cart Component](/styleguides/components%3Ashopping-cart-table/).

It is possible to edit items in basket (changing quantity or deleting items - not working in this demo). 

In real usage basket contents and price are loaded asynchronously by JS - therefore there are hidden <code>.basket-loading</code> and <code>.basket-error</code> divs displayed during loading and in the case of loading error. For asynchronous content loading component's id must be set to <code>#offcanvas-basket</code>.

[example]
<a href="#" class="btn btn-primary" rel="nofollow" data-toggle="offcanvas" data-target="#offcanvas-basket-demo"
  aria-expanded="false" aria-controls="offcanvas-basket" aria-label="Košík"><span class="fas fa-shopping-cart"></span> Košík</a>

<div id="offcanvas-basket-demo" class="bs-offcanvas bs-offcanvas-right bg-light">
  <header class="bs-offcanvas-header bs-offcanvas-header--fixed-top">
    <button type="button" class="bs-offcanvas-close close" aria-label="Close" aria-expanded="true"><span
        class="fas fa-xmark"></span></button>
    <div class="h4 bs-offcanvas-title"><a href="/cs/baskets/edit/" rel="nofollow"><span
          class="fas fa-shopping-cart"></span>Košík<span class="cart-num-items js--cart-num-items">4</span></a>
    </div>
  </header>

  <div class="bs-offcanvas-content">
    <div class="basket-content" data-status="loaded">
      <div class="basket-content__items" data-items-count="4">
        <table class="table--offcanvas-basket">
          <tbody>
            <tr class="item">
              <td class="item__image">
                <a href="/hudba/power-corruption-lies/" aria-label="Power, Corruption &amp; Lies, CD - Detail produktu">
                  <img src="http://i.pupiq.net/i/6f/6f/9fe/2f9fe/1000x995/IJn0Vh_80x80xffffff_a5c97d0166301792.jpg"
                    width="80" height="80"></a>
              </td>
              <td class="item__name">
                <a href="/hudba/power-corruption-lies/">Power, Corruption &amp; Lies, CD</a>
              </td>
              <td class="item__quantity">
                <div class="quantity-widget quantity-widget--sm">
                  <button class="btn btn-sm btn-outline-secondary" disabled="">-</button>
                  <span class="quantity-widget__number">1 ks</span>
                  <a data-remote="true" data-method="post" class="btn btn-sm btn-outline-secondary remote_link post"
                    href="/cs/basket_items/increase_amount/?id=680">+</a> </div>
              </td>
              <td class="item__price"><span class="currency_main"><span
                    class="currency_main__price">540,00</span>&nbsp;<span class="currency_main__currency">Kč</span><span
                    class="currency_main__ordering-unit"></span></span>
              </td>
              <td class="item__actions"><a data-remote="true"
                  data-confirm="Opravdu chcete odstranit tento produkt z nákupního košíku?" data-method="post"
                  class="confirm remote_link post" href="/cs/basket_items/destroy/?id=680"><span
                    class="fas fa-times"></span></a>
              </td>
            </tr>
            <tr class="item">
              <td class="item__image">
                <a href="/hudba/ssss/" aria-label="Ssss - Detail produktu">
                  <img src="http://i.pupiq.net/i/6f/6f/1a5/301a5/600x600/xy1WFz_80x80xffffff_dace0c3a0a2152af.jpg"
                    width="80" height="80"></a>
              </td>
              <td class="item__name">
                <a href="/hudba/ssss/">Ssss</a>
              </td>
              <td class="item__quantity">
                <div class="quantity-widget quantity-widget--sm">
                  <button class="btn btn-sm btn-outline-secondary" disabled="">-</button>
                  <span class="quantity-widget__number">1 ks</span>
                  <a data-remote="true" data-method="post" class="btn btn-sm btn-outline-secondary remote_link post"
                    href="/cs/basket_items/increase_amount/?id=679">+</a> </div>
              </td>
              <td class="item__price"><span class="currency_main"><span
                    class="currency_main__price">560,00</span>&nbsp;<span class="currency_main__currency">Kč</span><span
                    class="currency_main__ordering-unit"></span></span>
              </td>
              <td class="item__actions"><a data-remote="true"
                  data-confirm="Opravdu chcete odstranit tento produkt z nákupního košíku?" data-method="post"
                  class="confirm remote_link post" href="/cs/basket_items/destroy/?id=679"><span
                    class="fas fa-times"></span></a>
              </td>
            </tr>
            <tr class="item">
              <td class="item__image">
                <a href="/produkt/cars/" aria-label="Cars - Detail produktu">
                  <img src="http://i.pupiq.net/i/6f/6f/a01/2fa01/600x613/60rCku_80x80xffffff_54f8e3ac052f989b.jpg"
                    width="80" height="80"></a>
              </td>
              <td class="item__name">
                <a href="/produkt/cars/">Cars</a>
              </td>
              <td class="item__quantity">
                <div class="quantity-widget quantity-widget--sm">
                  <button class="btn btn-sm btn-outline-secondary" disabled="">-</button>
                  <span class="quantity-widget__number">1 ks</span>
                  <a data-remote="true" data-method="post" class="btn btn-sm btn-outline-secondary remote_link post"
                    href="/cs/basket_items/increase_amount/?id=678">+</a> </div>
              </td>
              <td class="item__price"><span class="currency_main"><span
                    class="currency_main__price">212,50</span>&nbsp;<span class="currency_main__currency">Kč</span><span
                    class="currency_main__ordering-unit"></span></span>
              </td>
              <td class="item__actions"><a data-remote="true"
                  data-confirm="Opravdu chcete odstranit tento produkt z nákupního košíku?" data-method="post"
                  class="confirm remote_link post" href="/cs/basket_items/destroy/?id=678"><span
                    class="fas fa-times"></span></a>
              </td>
            </tr>
            <tr class="item">
              <td class="item__image">
                <a href="/hudba/physics/" aria-label="Physics - Detail produktu">
                  <img src="http://i.pupiq.net/i/6f/6f/22e/3322e/1000x1000/Ry4HVN_80x80xffffff_5e57f7508a56af69.webp"
                    width="80" height="80"></a>
              </td>
              <td class="item__name">
                <a href="/hudba/physics/">Physics</a>
              </td>
              <td class="item__quantity">
                <div class="quantity-widget quantity-widget--sm">
                  <button class="btn btn-sm btn-outline-secondary" disabled="">-</button>
                  <span class="quantity-widget__number">1 ks</span>
                  <a data-remote="true" data-method="post" class="btn btn-sm btn-outline-secondary remote_link post"
                    href="/cs/basket_items/increase_amount/?id=676">+</a> </div>
              </td>
              <td class="item__price"><span class="currency_main"><span
                    class="currency_main__price">160,00</span>&nbsp;<span class="currency_main__currency">Kč</span><span
                    class="currency_main__ordering-unit"></span></span>
              </td>
              <td class="item__actions"><a data-remote="true"
                  data-confirm="Opravdu chcete odstranit tento produkt z nákupního košíku?" data-method="post"
                  class="confirm remote_link post" href="/cs/basket_items/destroy/?id=676"><span
                    class="fas fa-times"></span></a>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="basket-content__total">
        <div class="description">Celková cena:</div>
        <div class="price"><span class="currency_main">
          <span class="currency_main__price">1&nbsp;473</span>&nbsp;<span
              class="currency_main__currency">Kč</span><span class="currency_main__ordering-unit"></span></span>
        </div>
      </div>
    </div>

    <div class="basket-loading">
			<div class="spinner-border text-secondary" role="status">
				<span class="sr-only">Loading...</span>
			</div>
			<p>Nahrávání</p>			
		</div>

    <div class="basket-error js--basket-error">
			Error
		</div>

    <div class="basket-link">
      <a href="/cs/baskets/edit/" class="btn btn-primary" rel="nofollow">K pokladně <span
          class="fas fa-angle-right"></span></a>
    </div>
  </div>
</div>
[/example]

## Other examples with different positioning and sizing
[example]
  <a href="#offcanvas-demo-left" class="btn btn-primary" data-toggle="offcanvas" aria-expanded="false" aria-controls="offcanvas-demo-left" >Offcanvas on left</a>
  <a href="#offcanvas-demo-fullwidth" class="btn btn-primary" data-toggle="offcanvas" aria-expanded="false" aria-controls="offcanvas-demo-fullwidth" >Fullwidth offcanvas</a>

  <div id="offcanvas-demo-left" class="bs-offcanvas bs-offcanvas-left bg-light">
    <header class="bs-offcanvas-header bs-offcanvas-header--fixed-top">
      <button type="button" class="bs-offcanvas-close close" aria-label="Close" aria-expanded="false"><span class="fas fa-xmark"></span></button>
      <h4 class="bs-offcanvas-title">Left Offcanvas Title</h4>
    </header>
    <div class="bs-offcanvas-content p-2">
      Offcanvas content 
    </div>    
  </div>

  <div id="offcanvas-demo-fullwidth" class="bs-offcanvas bs-offcanvas-right bs-offcanvas--fullwidth bg-light">
    <header class="bs-offcanvas-header bs-offcanvas-header--fixed-top">
      <button type="button" class="bs-offcanvas-close close" aria-label="Close" aria-expanded="false"><span class="fas fa-xmark"></span></button>
      <h4 class="bs-offcanvas-title">Left Offcanvas Title</h4>
    </header>
    <div class="bs-offcanvas-content p-2">
      Offcanvas content 
    </div>    
  </div>
[/example]

## Javascript

All Offcanvas components are controlled by <code>window.offCanvas</code> object (instance of <code>window.UTILS.BSOffCanvas</code> class). To open and close offcanvas components programatically , use <code>window.offCanvas.showOffCanvas( "myOffcanvasSelector", triggerEvent:Boolean )</code> (second parameter controls if <code>bs-offcanvas-show</code> would be fired) and <code>window.offCanvas.hideOffCanvas( "myOffcanvasSelector" )</code> methods.

When offcanvas is shown, <code>bs-offcanvas-show</code> is fired immediatelly as the animation begins. When offcanvas is hidden, <code>bs-offcanvas-hide</code> event is fired immediatelly as the animation begins. 
Example: <code>$( "#my-offcanvas" ).on( "bs-offcanvas-show", callback );</code>

Shopping cart preview is controlled by <code>window.basketOffcanvas</code> object (instance of <code>window.UTILS.OffcanvasBasket()</code> class). It automatically loads basket content from server. If you need to show basket preview with custom content, use <code>window.basketOffcanvas.showCustomBasket( "this is <strong>custom html content</strong>", 3000 );</code> where second parameter is optional timeout time to hide offcanvas automatically (Note: this method does not fire <code>bs-offcanvas-show</code> event).