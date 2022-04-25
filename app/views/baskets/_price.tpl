{assign currency $basket->getCurrency()}
{assign incl_vat $basket->displayPricesInclVat()}
{!$price->getPrice($incl_vat)|display_price:"$currency"}
