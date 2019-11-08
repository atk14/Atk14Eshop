{assign container_id "app.trackers.google.tag_manager.container_id"|system_parameter}
{if $container_id}
<!-- Google Tag Manager -->
{literal}
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);{/literal}
})(window,document,'script','dataLayer','{$container_id}');</script>
<!-- End Google Tag Manager -->
{/if}
