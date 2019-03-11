CREATE SEQUENCE seq_campaigns;
CREATE TABLE campaigns (
	id INT PRIMARY KEY DEFAULT NEXTVAL('seq_campaigns'),
	active BOOLEAN NOT NULL DEFAULT TRUE,
	--
	-- podminky kampane
	region_id INT NOT NULL,
	user_registration_required BOOLEAN NOT NULL DEFAULT FALSE,
	minimal_items_price_incl_vat NUMERIC(12,4) NOT NULL, -- cena bez shipping poplatku
	delivery_method_id INT, -- vztahuje se pouze na dopravu
	--
	-- co zakaznik ziskava
	discount_percent NUMERIC(5,2) NOT NULL DEFAULT 0.0 CHECK (discount_percent>=0.0 AND discount_percent<=100.0),
	free_shipping BOOLEAN NOT NULL DEFAULT FALSE,
	--
	valid_from TIMESTAMP,
	valid_to TIMESTAMP,
	--
	created_by_user_id INT,
	updated_by_user_id INT,
	--
	created_at TIMESTAMP NOT NULL DEFAULT NOW(),
	updated_at TIMESTAMP,
	--
	CONSTRAINT chk_campaigns CHECK(
		(discount_percent=0.0 AND free_shipping=TRUE) OR
		(discount_percent>0.0 AND free_shipping=FALSE)
	),
	--
	CONSTRAINT fk_campaigns_deliverymethods FOREIGN KEY (delivery_method_id) REFERENCES delivery_methods,
	CONSTRAINT fk_campaigns_cr_users FOREIGN KEY (created_by_user_id) REFERENCES users,
	CONSTRAINT fk_campaigns_upd_users FOREIGN KEY (updated_by_user_id) REFERENCES users
);

CREATE SEQUENCE seq_order_campaigns;
CREATE TABLE order_campaigns (
	id INTEGER PRIMARY KEY DEFAULT NEXTVAL('seq_order_campaigns'),
	order_id INTEGER NOT NULL,
	campaign_id INTEGER NOT NULL,
	-- ke kampanim u objednavky si musime poznacit i slevu v dane mene
	discount_amount NUMERIC(12,4) NOT NULL,
	rank INTEGER DEFAULT 999 NOT NULL,
	CONSTRAINT unq_ordercampaigns UNIQUE (order_id,campaign_id),
	CONSTRAINT fk_order_campaigns_orders FOREIGN KEY (order_id) REFERENCES orders ON DELETE CASCADE,
	CONSTRAINT fk_order_campaigns_campaigns FOREIGN KEY (campaign_id) REFERENCES campaigns
);
CREATE INDEX in_ordercampaigns_campaignid ON order_campaigns(campaign_id);
