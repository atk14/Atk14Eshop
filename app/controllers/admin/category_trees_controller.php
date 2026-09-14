<?php
class CategoryTreesController extends AdminController{

	function index(){
		$this->page_title = _("Category trees");
		$this->tpl_data["roots"] = Category::GetCategories(null);
	}

	function create_new(){
		$this->page_title = _("Create new category tree");

		$this->_save_return_uri();
		if($this->request->post() && ($d = $this->form->validate($this->params))){
			$tags = $d["tags"];
			unset($d["tags"]);

			$d["created_by_user_id"] = $this->logged_user;
			$tree = Category::CreateNewRecord($d);
			$tree->setTags($tags);

			$this->flash->success(_("The category tree has been created"));
			$this->_redirect_back();
		}
	}

	function detail(){
		$this->page_title = _("Category tree");
		$this->tpl_data["tree"] = $this->_buildLightweightTree($this->root);
	}

	/**
	 * Builds a lightweight category tree without loading full ORM objects.
	 *
	 * Uses two focused SQL queries instead of Cache::Get('Category', all_ids):
	 *   1. Recursive CTE — fetches only the columns the template needs.
	 *   2. category_tags query — precomputes vehicle-tag membership.
	 *
	 * All category data is held in two plain PHP arrays shared by reference
	 * across all CategoryNodeLightweight instances, so memory use is
	 * proportional to (number of categories × handful of scalar fields).
	 */
	private function _buildLightweightTree($root) {
		$dbmole = Category::GetDbMole();

		// One recursive query — only the columns the template actually uses.
		// Names are stored in the translations table (key='name', lang='cs'/'en').
		// Recursion follows real_id = COALESCE(pointing_to_category_id, id) so that
		// children of aliased categories are included (same as CategoryTree behaviour).
		$rows = $dbmole->selectRows(
			"WITH RECURSIVE subtree(id, real_id, parent_category_id, rank) AS (
				SELECT id, COALESCE(pointing_to_category_id, id), parent_category_id, rank
				FROM categories WHERE id = :root_id
			UNION
				SELECT c.id, COALESCE(c.pointing_to_category_id, c.id), c.parent_category_id, c.rank
				FROM categories c
				JOIN subtree s ON c.parent_category_id = s.real_id
			)
			SELECT
				c.id,
				COALESCE(c.pointing_to_category_id, c.id) AS real_id,
				c.parent_category_id,
				c.visible, c.is_filter, c.pointing_to_category_id,
				MAX(CASE WHEN t.key = 'name' AND t.lang = 'cs' THEN t.body END) AS name_cs,
				MAX(CASE WHEN t.key = 'name' AND t.lang = 'en' THEN t.body END) AS name_en
			FROM categories c
			JOIN subtree s ON c.id = s.id
			LEFT JOIN translations t
				ON t.table_name = 'categories' AND t.record_id = c.id AND t.key = 'name'
			GROUP BY c.id, c.parent_category_id, c.visible, c.is_filter, c.pointing_to_category_id, c.rank
			ORDER BY c.parent_category_id, c.rank, c.id",
			[':root_id' => $root->getId()]
		);

		$ids = array_column($rows, 'id');

		// Precompute vehicle-tag membership for all categories in one query.
		$vehicle_ids = [];
		$vehicle_tag = Tag::GetInstanceByCode("vehicle");
		if ($vehicle_tag && $ids) {
			$vehicle_ids = array_flip($dbmole->selectIntoArray(
				"SELECT category_id FROM category_tags
				 WHERE tag_id = :tag_id AND category_id IN :ids",
				[':tag_id' => $vehicle_tag, ':ids' => $ids],
				'integer'
			));
		}

		// Build flat index and parent→children map (children ordered by rank).
		$nodes    = [];
		$children = [];
		foreach ($rows as $row) {
			$row['has_vehicle_tag'] = isset($vehicle_ids[$row['id']]);
			$nodes[$row['id']] = $row;
			$children[(string)$row['parent_category_id']][] = $row['id'];
		}

		return new CategoryNodeLightweight($root->getId(), $nodes, $children);
	}

	function set_rank() {
		if(!$this->request->post()){ return $this->_execute_action("error404"); }

		$this->render_template = false;
		$this->root->setRank($this->params->getInt("rank"));
	}

	function destroy(){
		if(!$this->request->post() || !$this->root->isDeletable()){
			return $this->_execute_action("error404");
		}

		$this->root->destroy();
	}

	function _before_filter(){
		if(in_array($this->action,array("detail","set_rank","destroy"))){
			$this->_find("root", array("class_name" => "Category"));
		}
	}
}
