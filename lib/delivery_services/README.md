Imoprt of branches
------------------

    ./scripts/robot_runner import_delivery_service_branches <delivery service code>

Delivery service code can be found in field code of table delivery_services


Deprecation of feed for Zasilkovna
----------------------------------

XML feed with Zasilkovna (Packeta) branches in version 4 will be obsolete and so will the import class Zasilkovna. Use class ZasilkovnaV5 instead.

Update to use feed version 5.
----------------------------

To use the new class is very simple. Just update the code of Zasilkovna in the delivery_services table:

    UPDATE delivery_services SET code='zasilkovna_v5' WHERE code='zasilkovna'

Then import of branches is done by

    ./scripts/robot_runner import_delivery_service_branches zasilkovna_v5
