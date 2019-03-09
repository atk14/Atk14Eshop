CREATE SEQUENCE seq_hidden_stock_reserves;
CREATE TABLE hidden_stock_reserves (
	id INT PRIMARY KEY DEFAULT NEXTVAL('seq_hidden_stock_reserves'),
	--
	-- budto budou nastaveny tyto dve pole,...
	category_id INT,
	unit_id INT,
	--
	-- ... nebo toto pole
	product_id INT,
	--
	reserve INT NOT NULL,
	--
	-- Pokud je stockcount produktu po odecteni skryte rezervy (hidden_stock_reserves.reserve) mensi
	-- nez hidden_stock_reserves.lowest_offered_quantity, uz se tento produkt prestava zobrazovat v nabidce.
	lowest_offered_quantity INT NOT NULL DEFAULT 0,
	--
	created_by_user_id INT,
	updated_by_user_id INT,
	--
	created_at TIMESTAMP NOT NULL DEFAULT NOW(),
	updated_at TIMESTAMP,
	--
	CONSTRAINT unq_hiddenstockreserves_productid UNIQUE(product_id),
	CONSTRAINT unq_hiddenstockreserves_categoryid_unitid UNIQUE(category_id,unit_id),
	CONSTRAINT chk_hiddenstockreserves CHECK((category_id IS NULL AND unit_id IS NULL AND product_id IS NOT NULL) OR (category_id IS NOT NULL AND unit_id IS NOT NULL AND product_id IS NULL)),
	--
	CONSTRAINT fk_hiddenstockreserves_units FOREIGN KEY (unit_id) REFERENCES units ON DELETE CASCADE,
	CONSTRAINT fk_hiddenstockreserves_categories FOREIGN KEY (category_id) REFERENCES categories ON DELETE CASCADE,
	CONSTRAINT fk_hiddenstockreserves_products FOREIGN KEY (product_id) REFERENCES products ON DELETE CASCADE,
	--
	CONSTRAINT fk_hiddenstockreserves_cr_users FOREIGN KEY (created_by_user_id) REFERENCES users,
	CONSTRAINT fk_hiddenstockreserves_upd_users FOREIGN KEY (updated_by_user_id) REFERENCES users
);

-- defaultni rezerva 100cm
-- INSERT INTO hidden_stock_reserves (category_id, unit_id, reserve) VALUES((SELECT id FROM categories WHERE code='catalog'),(SELECT id FROM units WHERE unit='cm'),100);
