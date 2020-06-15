ALTER TABLE delivery_services ADD COLUMN branches_download_url VARCHAR(255) NOT NULL;

INSERT INTO delivery_services (code, name, branches_download_url) VALUES ('cp-balik-na-postu', 'Česká Pošta - Balík na poštu', 'http://napostu.ceskaposta.cz/vystupy/napostu.xml');
INSERT INTO delivery_services (code, name, branches_download_url) VALUES ('cp-balikovna', 'Česká Pošta - Balíkovna', 'http://napostu.ceskaposta.cz/vystupy/balikovny.xml');
INSERT INTO delivery_services (code, name, branches_download_url) VALUES ('zasilkovna', 'Zásilkovna', 'https://www.zasilkovna.cz/api/v3/{API_KEY_ZASILKOVNA}/branch.xml');

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


-- ALTER TABLE delivery_methods ADD COLUMN delivery_service_id INTEGER;
-- ALTER TABLE delivery_methods ADD CONSTRAINT fk_delivery_methods_delivery_service_id FOREIGN KEY (delivery_service_id) REFERENCES delivery_services;

-- ALTER TABLE baskets ADD COLUMN delivery_method_data JSON;
COMMENT ON COLUMN baskets.delivery_method_data IS 'dodatecne informace o miste doruceni - pobocce dorucovaci sluzby';

-- ALTER TABLE orders ADD COLUMN delivery_method_data JSON;
COMMENT ON COLUMN orders.delivery_method_data IS 'dodatecne informace o miste doruceni - pobocce dorucovaci sluzby';

INSERT INTO system_parameters (code, content, system_parameter_type_id, mandatory) VALUES ('delivery_services.zasilkovna.api_key', '', 1, 'f');
INSERT INTO translations (table_name, record_id, key, lang, body) VALUES ('system_parameters', (SELECT id FROM system_parameters WHERE code='delivery_services.zasilkovna.api_key'), 'name', 'cs', 'Zásilkovna API klíč');
INSERT INTO translations (table_name, record_id, key, lang, body) VALUES ('system_parameters', (SELECT id FROM system_parameters WHERE code='delivery_services.zasilkovna.api_key'), 'name', 'en', 'Zásilkovna API key');
INSERT INTO translations (table_name, record_id, key, lang, body) VALUES ('system_parameters', (SELECT id FROM system_parameters WHERE code='delivery_services.zasilkovna.api_key'), 'description', 'cs', 'Klíč pro přístup k API služby Zásilkovna.cz');
INSERT INTO translations (table_name, record_id, key, lang, body) VALUES ('system_parameters', (SELECT id FROM system_parameters WHERE code='delivery_services.zasilkovna.api_key'), 'description', 'en', 'Key for access to API to the service Zásilkovna.cz');
