ALTER TABLE campaigns ADD required_delivery_method_id INT;
ALTER TABLE campaigns ADD CONSTRAINT fk_campaigns_reqdeliverymethods FOREIGN KEY (required_delivery_method_id) REFERENCES delivery_methods;

ALTER TABLE campaigns ADD required_payment_method_id INT;
ALTER TABLE campaigns ADD CONSTRAINT fk_campaigns_reqpaymentmethods FOREIGN KEY (required_payment_method_id) REFERENCES payment_methods;
