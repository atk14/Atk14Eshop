ALTER TABLE link_list_items ADD regions JSON;
UPDATE link_list_items SET regions='{"CZ": true}';
