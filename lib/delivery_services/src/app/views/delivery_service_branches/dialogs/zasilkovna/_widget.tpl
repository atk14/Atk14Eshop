{assign delivery_service $delivery_method->getDeliveryService()}
{assign service_key "delivery_services.zasilkovna.api_key"}
<div id="atk14-widget-zasilkovna" data-api_key="{$service_key|system_parameter}"></div>
{render partial="shared/form"}

