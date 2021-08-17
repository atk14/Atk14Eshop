ALTER TABLE payment_transactions ADD currency_id INT;
ALTER TABLE payment_transactions ADD price_to_pay NUMERIC(20,6);

UPDATE payment_transactions SET currency_id=(SELECT currency_id FROM orders WHERE id=payment_transactions.order_id);
ALTER TABLE payment_transactions ALTER currency_id SET NOT NULL;
UPDATE payment_transactions SET price_to_pay=(SELECT price_to_pay FROM orders WHERE id=payment_transactions.order_id);
ALTER TABLE payment_transactions ALTER price_to_pay SET NOT NULL;

ALTER TABLE payment_transactions ADD rank INT NOT NULL DEFAULT 1;

ALTER TABLE payment_transactions DROP CONSTRAINT unq_paymenttransactions_orderid;
ALTER TABLE payment_transactions ADD CONSTRAINT unq_paymenttransactions_orderid_rank UNIQUE(order_id,rank);
