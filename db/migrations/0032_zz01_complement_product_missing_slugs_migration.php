<?php
class Zz01ComplementProductMissingSlugsMigration extends ApplicationMigration {

	function up(){
		$ids = $this->dbmole->selectIntoArray("SELECT DISTINCT(record_id) FROM translations WHERE table_name='products' AND key='label' ORDER BY record_id DESC");
		foreach($ids as $id){
			$product = Product::GetInstanceById($id);
			if(!$product){ continue; }

			$this->logger->info("about to process Product#{$product->getId()} (catalog_id: {$product->getCatalogId()}, name: {$product->getName()})");
			$this->logger->flush();

			Slug::ComplementSlugs($product);
		}
	}
}
