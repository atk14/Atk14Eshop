ALTER TABLE regions ADD invoice_countries JSON; -- e.g. ['CZ'] or ['CZ','SK'] or NULL
UPDATE regions SET invoice_countries=delivery_countries;
