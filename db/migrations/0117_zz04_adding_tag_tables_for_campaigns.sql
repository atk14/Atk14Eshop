CREATE SEQUENCE seq_campaign_designated_for_tags;
CREATE TABLE campaign_designated_for_tags(
	id INTEGER PRIMARY KEY DEFAULT NEXTVAL('seq_campaign_designated_for_tags'),
	campaign_id INTEGER NOT NULL,
	tag_id INTEGER NOT NULL,
	rank INTEGER DEFAULT 999 NOT NULL,
	CONSTRAINT fk_campaigndsgnttags_campaigns FOREIGN KEY (campaign_id) REFERENCES campaigns ON DELETE CASCADE,
	CONSTRAINT fk_campaigndsgnttags_tags FOREIGN KEY (tag_id) REFERENCES tags ON DELETE CASCADE
);

CREATE SEQUENCE seq_campaign_excluded_for_tags;
CREATE TABLE campaign_excluded_for_tags (
	id INTEGER PRIMARY KEY DEFAULT NEXTVAL('seq_campaign_excluded_for_tags'),
	campaign_id INTEGER NOT NULL,
	tag_id INTEGER NOT NULL,
	rank INTEGER DEFAULT 999 NOT NULL,
	CONSTRAINT fk_campaignexcltags_campaigns FOREIGN KEY (campaign_id) REFERENCES campaigns ON DELETE CASCADE,
	CONSTRAINT fk_campaignexcltags_tags FOREIGN KEY (tag_id) REFERENCES tags ON DELETE CASCADE
);
