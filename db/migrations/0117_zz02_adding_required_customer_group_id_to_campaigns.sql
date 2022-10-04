ALTER TABLE campaigns ADD COLUMN required_customer_group_id INT;
ALTER TABLE campaigns ADD CONSTRAINT fk_campaigns_reqcustomergroups FOREIGN KEY (required_customer_group_id) REFERENCES customer_groups;

-- the new field is replacing field user_registration_required which shall be dropped
UPDATE campaigns SET required_customer_group_id=(SELECT id FROM customer_groups WHERE code='registered') WHERE user_registration_required;
ALTER TABLE campaigns DROP COLUMN user_registration_required;
