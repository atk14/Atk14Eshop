CREATE SEQUENCE seq_category_tags;
CREATE TABLE category_tags(
	id INTEGER PRIMARY KEY DEFAULT NEXTVAL('seq_category_tags'),
	category_id INTEGER NOT NULL,
	tag_id INTEGER NOT NULL,
	rank INTEGER DEFAULT 999 NOT NULL,
	CONSTRAINT fk_category_tags_categories FOREIGN KEY (category_id) REFERENCES categories ON DELETE CASCADE,
	CONSTRAINT fk_category_tags_tags FOREIGN KEY (tag_id) REFERENCES tags ON DELETE CASCADE
);
CREATE INDEX in_categorytags_categoryid ON category_tags(category_id);
CREATE INDEX in_categorytags_tagid ON category_tags(tag_id);
