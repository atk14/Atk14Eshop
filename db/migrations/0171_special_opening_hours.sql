CREATE SEQUENCE seq_special_opening_hours;

CREATE TABLE special_opening_hours (
	id INT PRIMARY KEY DEFAULT NEXTVAL('seq_special_opening_hours'),
	--
	store_id INT NOT NULL,
	date DATE NOT NULL,
	--
	opening_hours1 NUMERIC(4,2),
	opening_hours2 NUMERIC(4,2),
	opening_hours3 NUMERIC(4,2),
	opening_hours4 NUMERIC(4,2),
	--
	created_by_user_id INT,
	updated_by_user_id INT,
	--
	created_at TIMESTAMP NOT NULL DEFAULT NOW(),
	updated_at TIMESTAMP,
	--
	CONSTRAINT unq_specialopeninghours_code UNIQUE(store_id,date),
	CONSTRAINT fk_specialopeninghours_stores FOREIGN KEY (store_id) REFERENCES stores ON DELETE CASCADE,
	CONSTRAINT fk_specialopeninghours_cr_users FOREIGN KEY (created_by_user_id) REFERENCES users,
	CONSTRAINT fk_specialopeninghours_upd_users FOREIGN KEY (updated_by_user_id) REFERENCES users
);
