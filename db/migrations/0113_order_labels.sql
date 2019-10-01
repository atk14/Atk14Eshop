CREATE SEQUENCE seq_order_labels;
CREATE TABLE order_labels (
	id INT PRIMARY KEY DEFAULT NEXTVAL('seq_order_labels'),
	--
	color VARCHAR(255) NOT NULL,
	rank INT NOT NULL DEFAULT 999,
	--
	created_by_user_id INT,
	updated_by_user_id INT,
	--
	created_at TIMESTAMP NOT NULL DEFAULT NOW(),
	updated_at TIMESTAMP,
	--
	CONSTRAINT fk_orderlabels_cr_users FOREIGN KEY (created_by_user_id) REFERENCES users,
	CONSTRAINT fk_orderlabels_upd_users FOREIGN KEY (updated_by_user_id) REFERENCES users
);

INSERT INTO order_labels (color) VALUES('#ff9292');
INSERT INTO order_labels (color) VALUES('#68c5e7');
INSERT INTO order_labels (color) VALUES('#87e897');
INSERT INTO order_labels (color) VALUES('#fdff70');
INSERT INTO order_labels (color) VALUES('#ffb370');
INSERT INTO order_labels (color) VALUES('#caa0ff');

