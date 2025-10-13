-- more creators can be linked to the same profile page
ALTER TABLE creators DROP CONSTRAINT unq_creators_pageid;

CREATE INDEX in_creators_pageid ON creators(page_id);
