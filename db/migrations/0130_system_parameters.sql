CREATE TABLE system_parameter_types (
	id INT PRIMARY KEY,
	code VARCHAR(255) NOT NULL,
	--
	CONSTRAINT unq_systemparametertypes_code UNIQUE (code)
);
INSERT INTO system_parameter_types VALUES (1,'string');
INSERT INTO system_parameter_types VALUES (2,'localized_string');
INSERT INTO system_parameter_types VALUES (3,'text');
INSERT INTO system_parameter_types VALUES (4,'localized_text');
INSERT INTO system_parameter_types VALUES (5,'integer');
INSERT INTO system_parameter_types VALUES (6,'float');
INSERT INTO system_parameter_types VALUES (7,'boolean');
INSERT INTO system_parameter_types VALUES (8,'url');

CREATE SEQUENCE seq_system_parameters;
CREATE TABLE system_parameters (
	id INT PRIMARY KEY DEFAULT NEXTVAL('seq_system_parameters'),
	code VARCHAR(255) NOT NULL,
	system_parameter_type_id INT NOT NULL,
	mandatory BOOLEAN NOT NULL DEFAULT FALSE,
	read_only BOOLEAN NOT NULL DEFAULT FALSE,
	content TEXT,
	--
	created_by_user_id INT,
	updated_by_user_id INT,
	--
	created_at TIMESTAMP NOT NULL DEFAULT NOW(),
	updated_at TIMESTAMP,
	--
	CONSTRAINT unq_systemparameters_code UNIQUE (code),
	CONSTRAINT fk_systemparameters_systemparametertypes FOREIGN KEY (system_parameter_type_id) REFERENCES system_parameter_types,
	--
	CONSTRAINT fk_systemparameters_cr_users FOREIGN KEY (created_by_user_id) REFERENCES users,
	CONSTRAINT fk_systemparameters_upd_users FOREIGN KEY (updated_by_user_id) REFERENCES users
);
