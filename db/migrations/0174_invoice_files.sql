CREATE SEQUENCE seq_invoice_files;

CREATE TABLE invoice_files (
	id INT PRIMARY KEY DEFAULT NEXTVAL('seq_invoice_files'),
	--
	order_id INT NOT NULL,
	secret VARCHAR(255) NOT NULL,
	--
	invoice_no VARCHAR(255),
	document_date DATE, -- 
	due_date DATE, -- datum splatnosti
	--
  path VARCHAR(255) NOT NULL,
	filename VARCHAR(255) NOT NULL,
	filesize INTEGER NOT NULL,
	mime_type VARCHAR(255) NOT NULL,
	--
	notified BOOLEAN NOT NULL DEFAULT FALSE,
	notified_at TIMESTAMP,
	--
	rank INTEGER DEFAULT 999 NOT NULL,
	--
	created_by_user_id INT,
	updated_by_user_id INT,
	--
	created_at TIMESTAMP NOT NULL DEFAULT NOW(),
	updated_at TIMESTAMP,
	--
	CONSTRAINT fk_invoicefiles_orders FOREIGN KEY (order_id) REFERENCES orders ON DELETE CASCADE,
	CONSTRAINT chk_invoicefiles_notified CHECK((notified=FALSE AND notified_at IS NULL) OR (notified=TRUE AND notified_at IS NOT NULL)),
	CONSTRAINT fk_invoicefiles_cr_users FOREIGN KEY (created_by_user_id) REFERENCES users,
	CONSTRAINT fk_invoicefiles_upd_users FOREIGN KEY (updated_by_user_id) REFERENCES users
);

CREATE INDEX in_invoicefiles_orderid ON invoice_files (order_id);
