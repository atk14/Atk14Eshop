ALTER TABLE order_campaigns ADD free_shipping BOOLEAN NOT NULL DEFAULT FALSE;
ALTER TABLE order_campaigns DROP CONSTRAINT unq_ordercampaigns; -- UNIQUE CONSTRAINT, btree (order_id, campaign_id)
ALTER TABLE order_campaigns ADD CONSTRAINT unq_ordercampaigns UNIQUE (order_id,campaign_id,free_shipping);
ALTER TABLE order_campaigns ADD vat_percent NUMERIC(5,2);
