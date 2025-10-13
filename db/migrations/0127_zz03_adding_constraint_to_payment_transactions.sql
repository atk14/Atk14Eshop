ALTER TABLE payment_transactions ADD CONSTRAINT fk_paymenttransactions_orders FOREIGN KEY (order_id) REFERENCES orders;
