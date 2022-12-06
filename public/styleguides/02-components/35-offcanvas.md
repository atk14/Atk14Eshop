Offcanvas component
===================

Offcanvas sidebar useful for navigation. ATK14Eshop shopping cart preview is built with this component.

Offcanvas can be opened by clicking element with <code>data-toggle="offcanvas"</code> attribute with <code>data-target</code> or <code>href</code> which specifies target offcanvas element (<code>data-target</code> has higher priority). Offcanvas content is scrollable if it is longer than available height.

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

## Other examples
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