CREATE SEQUENCE seq_sliders;
CREATE TABLE sliders (
	id INT PRIMARY KEY DEFAULT NEXTVAL('seq_sliders'),
	code VARCHAR(255),
	--
	name VARCHAR(255),
	--
	rank INT DEFAULT 999 NOT NULL,
	--
	created_by_user_id INT,
	updated_by_user_id INT,
	--
	created_at TIMESTAMP NOT NULL DEFAULT NOW(),
	updated_at TIMESTAMP,
	--
	CONSTRAINT unq_sliders_code UNIQUE (code),
	CONSTRAINT fk_sliders_cr_users FOREIGN KEY (created_by_user_id) REFERENCES users,
	CONSTRAINT fk_sliders_upd_users FOREIGN KEY (updated_by_user_id) REFERENCES users
);

CREATE SEQUENCE seq_slider_items;
CREATE TABLE slider_items (
	id INT PRIMARY KEY DEFAULT NEXTVAL('seq_slider_items'),
	--
	slider_id INT NOT NULL,
	image_url VARCHAR(255) NOT NULL,
	text_color VARCHAR(255),
	background_color VARCHAR(255),
	url VARCHAR(255),
	url_params JSON,
	visible BOOLEAN NOT NULL DEFAULT TRUE,
	--
	rank INT DEFAULT 999 NOT NULL,
	--
	created_by_user_id INT,
	updated_by_user_id INT,
	--
	created_at TIMESTAMP NOT NULL DEFAULT NOW(),
	updated_at TIMESTAMP,
	--
	CONSTRAINT fk_slideritems_sliders FOREIGN KEY (slider_id) REFERENCES sliders ON DELETE CASCADE,
	CONSTRAINT fk_slideritems_cr_users FOREIGN KEY (created_by_user_id) REFERENCES users,
	CONSTRAINT fk_slideritems_upd_users FOREIGN KEY (updated_by_user_id) REFERENCES users
);
