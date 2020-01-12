CREATE SEQUENCE seq_wiki_pages;
CREATE TABLE wiki_pages (
	id INT NOT NULL PRIMARY KEY DEFAULT NEXTVAL('seq_wiki_pages'),
	--
	wiki_name VARCHAR(255) NOT NULL DEFAULT 'wiki', -- wiki, public, internal_wiki, user_manual...
	--
	name VARCHAR(255) NOT NULL, -- ImportingArticles, Payments, etc.
	revision INT DEFAULT 1 NOT NULL,
	--
	content TEXT,
	--
	deleted BOOLEAN NOT NULL DEFAULT FALSE,
	--
	created_from_addr VARCHAR(255),
	created_from_hostname VARCHAR(255),
	updated_from_addr VARCHAR(255),
	updated_from_hostname VARCHAR(255),
	--
	created_by_user_id INT,
	updated_by_user_id INT,
	--
	created_at TIMESTAMP NOT NULL DEFAULT NOW(),
	updated_at TIMESTAMP,
	--
	CONSTRAINT fk_wikipages_cr_users FOREIGN KEY (created_by_user_id) REFERENCES users,
	CONSTRAINT fk_wikipages_upd_users FOREIGN KEY (updated_by_user_id) REFERENCES users,
	CONSTRAINT unq_wikipages UNIQUE (wiki_name,name,revision)
);

CREATE SEQUENCE seq_wiki_attachments;
CREATE TABLE wiki_attachments (
	id INT PRIMARY KEY DEFAULT NEXTVAL('seq_wiki_attachments'),
	--
	wiki_page_id INT NOT NULL,
	filename VARCHAR(255) NOT NULL,
	filesize INT NOT NULL,
	mime_type VARCHAR(255) NOT NULL,
	content TEXT NOT NULL,
	checksum VARCHAR(255) NOT NULL,
	--
	image_width INT,
	image_height INT,
	--
	created_by_user_id INT,
	updated_by_user_id INT,
	--
	created_at TIMESTAMP NOT NULL DEFAULT NOW(),
	updated_at TIMESTAMP,
	--
	CONSTRAINT unq_wikiattachments_filename UNIQUE (wiki_page_id,filename),
	CONSTRAINT fk_wikiattachments_cr_users FOREIGN KEY (created_by_user_id) REFERENCES users,
	CONSTRAINT fk_wikiattachments_upd_users FOREIGN KEY (updated_by_user_id) REFERENCES users
);

CREATE INDEX in_wikiattachments_wikipageid ON wiki_attachments(wiki_page_id);
