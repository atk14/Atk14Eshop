{assign settings CookieConsent::GetSettings()}
{assign consent_value "revoke"}
{if CookieConsent::Accepted("advertising")}
	{assign consent_value "grant"}
{/if}

<script>
{literal}
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
{/literal}
  fbq('consent', '{$consent_value}');
  fbq('init', '{$facebook_pixel_id}');
  fbq('track', 'PageView');
  {if $settings && $settings->needsToBeConfirmed()}
    document.addEventListener( "consentupdate", function( ev ) \{
      var ad_consent = ev.grantedConsents.ad_storage;
      fbq('consent', ad_consent === "granted" ? "grant" : "revoke" );
    } );
  {/if}
</script>
