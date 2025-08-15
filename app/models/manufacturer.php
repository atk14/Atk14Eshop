<?php
class Manufacturer extends ApplicationModel implements Rankable, iSlug {

	function getSlugPattern($lang){ return $this->getName(); }

	function setRank($new_rank) { return $this->_setRank($new_rank); }
}

