{assign delivery_service $delivery_method->getDeliveryService()}
{assign service_key "delivery_services.zasilkovna.api_key"}
{if $delivery_service && $delivery_service->getCode()=="zasilkovna_v5"}
{assign service_key "delivery_services.zasilkovna_v5.api_key"}
{/if}
<div id="atk14-widget-zasilkovna" data-api_key="{$service_key|system_parameter}"></div>
{render partial="shared/form"}

