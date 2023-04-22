ALTER TABLE units ADD stockcount_display_limit INT NOT NULL DEFAULT 10000;

UPDATE units SET stockcount_display_limit=10 WHERE unit='pcs';
UPDATE units SET stockcount_display_limit=1000 WHERE unit='cm';
UPDATE units SET stockcount_display_limit=10000 WHERE unit='g';
