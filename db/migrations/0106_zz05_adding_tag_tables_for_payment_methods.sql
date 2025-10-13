CREATE SEQUENCE seq_payment_method_designated_for_tags;
CREATE TABLE payment_method_designated_for_tags(
	id INTEGER PRIMARY KEY DEFAULT NEXTVAL('seq_payment_method_designated_for_tags'),
	payment_method_id INTEGER NOT NULL,
	tag_id INTEGER NOT NULL,
	rank INTEGER DEFAULT 999 NOT NULL,
	CONSTRAINT fk_paymentmethoddsgnttags_paymentmethods FOREIGN KEY (payment_method_id) REFERENCES payment_methods ON DELETE CASCADE,
	CONSTRAINT fk_paymentmethoddsgnttags_tags FOREIGN KEY (tag_id) REFERENCES tags ON DELETE CASCADE
);

CREATE SEQUENCE seq_payment_method_excluded_for_tags;
CREATE TABLE payment_method_excluded_for_tags (
	id INTEGER PRIMARY KEY DEFAULT NEXTVAL('seq_payment_method_excluded_for_tags'),
	payment_method_id INTEGER NOT NULL,
	tag_id INTEGER NOT NULL,
	rank INTEGER DEFAULT 999 NOT NULL,
	CONSTRAINT fk_paymentmethodexcltags_paymentmethods FOREIGN KEY (payment_method_id) REFERENCES payment_methods ON DELETE CASCADE,
	CONSTRAINT fk_paymentmethodexcltags_tags FOREIGN KEY (tag_id) REFERENCES tags ON DELETE CASCADE
);
