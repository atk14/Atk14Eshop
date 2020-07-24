CREATE SEQUENCE seq_delivery_service_branches;

CREATE TABLE delivery_service_branches (
	id INTEGER PRIMARY KEY DEFAULT NEXTVAL('seq_delivery_service_branches'),

	active BOOLEAN NOT NULL DEFAULT 't',

	delivery_service_id INTEGER NOT NULL,

-- internal id used by delivery service
-- jednoznacny identifikator pobocky, ktery pouziva dorucovaci sluzba
-- napr. zip u Ceske Posty, branch_id u Zasilkovny
	external_branch_id VARCHAR(255) NOT NULL,
	name VARCHAR(255) NOT NULL,
	place VARCHAR(255) NOT NULL,
	street VARCHAR(255) NOT NULL,
	city VARCHAR(255) NOT NULL,
	district VARCHAR(255) NOT NULL,
	zip VARCHAR(20) NOT NULL,
	country VARCHAR(2) NOT NULL,
	full_address VARCHAR(255),

	url VARCHAR(255),
	location_latitude float,
	location_longitude float,
	opening_hours JSON,

	created_at TIMESTAMP NOT NULL DEFAULT NOW(),
	updated_at TIMESTAMP,

	CONSTRAINT fk_delivery_service_service_id FOREIGN KEY (delivery_service_id) REFERENCES delivery_services ON DELETE CASCADE,
	CONSTRAINT unq_delivery_service_branches__service_id_branch_id UNIQUE (delivery_service_id, external_branch_id)
);

COMMENT ON COLUMN baskets.delivery_method_data IS 'dodatecne informace o miste doruceni - pobocce dorucovaci sluzby';
COMMENT ON COLUMN orders.delivery_method_data IS 'dodatecne informace o miste doruceni - pobocce dorucovaci sluzby';
