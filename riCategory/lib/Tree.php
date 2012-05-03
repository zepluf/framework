<?php
/**
 * Simple Category Tree
 * @Version: Beta 2
 * @Authour: yellow1912
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 */ 

namespace plugins\riCategory;

class Tree {
	private $tree = array(),
			$is_deepest_cats_built = false,
			$current_id = -1,
			$exceptional_list = array(),
			$new_id,
			$is_attached = false;
	
	function __construct(){		
			global $languages_id, $db;
			$categories_query = "select *
	                      from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd
	                      where c.categories_id = cd.categories_id
	                      and c.categories_status=1
						  and cd.language_id = '" . (int)$_SESSION['languages_id'] . "'
	                      order by c.parent_id, c.sort_order, cd.categories_name";
			$categories = $db->Execute($categories_query);

			// reset the tree first
			$this->tree = array(); 
			$this->is_deepest_cats_built = false;
			while (!$categories->EOF) {
				$this->tree[$categories->fields['categories_id']] = $categories->fields;								
				$this->tree[$categories->fields['categories_id']]['path'][] = $categories->fields['categories_id'];
				$this->tree[$categories->fields['parent_id']]['children'][] = $categories->fields['categories_id'];
				$categories->MoveNext();
			}
			
			// walk through the array and build sub/cPath and other addtional info needed
			foreach($this->tree as $key => $value){
				// add sub 'class' for print-out purpose
				$this->tree[$key]['has_children'] = isset($this->tree[$key]['children']);
				
				// only merge if parent cat is not 0
				if(isset($this->tree[$key]['parent_id']) && $this->tree[$key]['parent_id'] > 0){
					if(is_array($this->tree[$this->tree[$key]['parent_id']]['path']) && count($this->tree[$this->tree[$key]['parent_id']]['path'])> 0)
						$this->tree[$key]['path'] = array_merge($this->tree[$this->tree[$key]['parent_id']]['path'],$this->tree[$key]['path']);
				}
				$this->tree[$key]['nPath'] = $this->tree[$key]['cPath'] = isset($this->tree[$key]['path']) ? implode('_',$this->tree[$key]['path']) : $key;
			}
			// for debugging using super global mod
			// $_POST['category_tree'] = $this->tree;
		
		// This special portion of code was added to catch the current category selected
		$this->current_id = $this->getCurrentNavId();
		$this->exceptional_list = array();
		
		if($this->current_id != -1){
			$cPath = $this->getCpath($this->current_id);
			if(!empty($cPath)){
				$this->exceptional_list = explode('_', $cPath);
			}
		}
	}
	
	function getCurrentNavId(){
		$cPath = $_GET['cPath'];
		if(isset($_GET['nPath']))
			$cPath = $_GET['nPath'];
		if(empty($cPath))
			return -1;
		return $this->_getId($cPath);
	}
	
	function getCpath($categories_id){
		$categories_id = $this->_getId($categories_id);
		return (isset($this->tree[$categories_id]['cPath']) ? $this->tree[$categories_id]['cPath'] : '');
	}
	
	public function getCategory($categories_id){
	    $categories_id = $this->_getId($categories_id);
		return $this->tree[$categories_id];	
	}
	
	function getTree(){
		return $this->tree;
	}	

	/**
	 * 
	 * Enter description here ...
	 */
	public function getVerticalCategory($categories_id){
		$tree = array();
		$this->_getVerticalCategory($categories_id, $tree, 0);
		return $tree;
	}
	
	public function _getVerticalCategory($categories_id, &$tree, $level){
		foreach($this->tree[$categories_id]['children'] as $sub_id){
			$category = $this->tree[$sub_id];
			$category['level'] = $level;			
			$tree[] = $category;
			if($this->tree[$sub_id]['has_children']){
				$this->_getVerticalCategory($sub_id, $tree, $level+1);
			}
		}
	}
	
	function getDeepestLevelChildren($categories_id){
	    $categories_id = $this->_getId($categories_id);
		$this->_buildDeepestLevelChildren($categories_id);
		$this->is_deepest_cats_built = true;
		return (isset($this->tree[$categories_id]['deepest_children']) ? $this->tree[$categories_id]['deepest_children'] : array());
	}	
	
	function _buildDeepestLevelChildren($categories_id){
		if(!$this->is_deepest_cats_built){
			$parent_id = isset($this->tree[$categories_id]['parent_id']) ? $this->tree[$categories_id]['parent_id'] : -1;
			if(isset($this->tree[$categories_id]['children'])){
				foreach($this->tree[$categories_id]['children'] as $sub_cat){
						// we now need to loop thru these cats, and find if they have sub_categories
						$this->_buildDeepestLevelChildren($sub_cat);
				}
			}
			elseif($parent_id > 0){
				$this->tree[$parent_id]['deepest_children'][] = $categories_id;
			}
			
			if($parent_id >= 0 && isset($this->tree[$categories_id]['deepest_children'])){
				if(isset($this->tree[$parent_id]['deepest_children']))
					$this->tree[$parent_id]['deepest_children'] = array_merge($this->tree[$parent_id]['deepest_children'],$this->tree[$categories_id]['deepest_children']);
				else
					$this->tree[$parent_id]['deepest_children'] = $this->tree[$categories_id]['deepest_children'];
			}			
		}
	}		
	
	function countSubCategories($categories_id){
		$categories_id = $this->_getId($categories_id);
		return isset($this->tree[$categories_id]['children']) ? 
				count($this->tree[$categories_id]['children']) : 0;
	}	

	public function getAllChildren($categories_id){
		$children = array();
		$this->_getAllChildren($categories_id, $children);
		return $children;		
	}
	
	public function _getAllChildren($categories_id, &$children){		
		foreach($this->tree[$categories_id]['children'] as $sub_id){			
			$children[] = $sub_id;
			if($this->tree[$sub_id]['sub']){
				$this->_getAllChildren($sub_id, $children);
			}
		}		
	}
		
	function _getId($categories_id){
		if(!is_int($categories_id)){
			$temp = explode('_',$categories_id);
			$categories_id = end($temp);
		}
		return $categories_id;
	}
	
	/*
	function startAttach(){
		if(SCT_REBUILD_TREE == 'true' || !$this->is_attached)
			return true;
		return false;
	}
	
	function endAttach(){
		$this->is_attached = true;
	}
	function attachToCategoryTree($new_node, $parent_id = 0){
		// we first need to find and assign a "fake" category id
		if(!isset($new_node['id']) || isset($this->tree[$new_node['id']])){
			if(!isset($this->new_id) && isset($this->tree[$parent_id]['children']) && count($this->tree[$parent_id]['children']) > 0)
				$this->new_id = end($this->tree[$parent_id]['children']);
			
			$current_id = ++$this->new_id;
		}
		else 
			$current_id = $new_node['id'];
			
		if(!is_numeric($this->tree[$parent_id]['nPath']) || $this->tree[$parent_id]['nPath'] != 0)
			$nPath = "{$this->tree[$parent_id]['nPath']}_{$current_id}";
		else 
			$nPath = $current_id;
			
		// we will then update its parent children. Since theese new add-on categories are "fake" and don't have
		// any product, we dont need to re-calculate the deepest_cats though.
		$this->tree[$parent_id]['children'][] = $current_id;

		if(isset($new_node['children']))
			$new_node['sub'] = 'has_sub'; 
		else 
			$new_node['sub'] = 'no_sub'; 
			
		$node = array('name' => $new_node['name'], 'parent_id' => $parent_id, 'path' => explode('_',$nPath), 'sub' => $new_node['sub'], 'cPath' => $new_node['cPath'], 'nPath' => $nPath);	

		$this->tree[$current_id] = $node;
		
		if(isset($new_node['children']))
			foreach($new_node['children'] as  $child)
				$this->attachToCategoryTree($child, $current_id);
	}
	*/
}