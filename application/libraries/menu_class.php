<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu_class
{
	private $menu_list;
	
	public function __construct()
	{
		$this->ci =& get_instance();
	}
	public function menu($id, $parent_id)
	{
	    $this->ci->load->model('page_model');
	    //$this->ci->load->model('common_class');
	    
	    // fetch all children of this page
	    $children = $this->ci->page_model->read(array('where' => array('parent_id' => $id)));
	    
	    // fetch all siblings of current page
	    $siblings = $this->ci->page_model->read(array('where' => array('parent_id' => $parent_id)));
	    
	    // fetch the current page's parent
	    if ($parent = $this->ci->page_model->read(array('where' => array('id' => $parent_id), 'limit' => 1)))
	    {
			// fetch all siblings of the parent page, as well as the parent page (parent, aunts, uncles)
			$parent_siblings = $this->ci->page_model->read(array('where' => array('parent_id' => $parent['parent_id'])));
	    }
	    else
	    {
			$parent_siblings = false;
	    }
	    
	    if ($siblings && $parent_siblings && $children)
	    {
			$tops = $parent_siblings;
			$mids = $siblings;
			$bots = $children;
	    }
	    elseif ($siblings && $parent_siblings)
	    {
			$tops = $parent_siblings;
			$mids = $siblings;
			$bots = array();
	    }
	    elseif ($siblings && $children)
	    {
			$tops = $siblings;
			$mids = $children;
			$bots = array();
	    }
	    else
	    {
			$tops = $siblings;
			$mids = array();
			$bots = array();
	    }
	    
		
			foreach ($tops as $top)
			{
				if ($this->ci->userdata['group']['name'] == 'Admin')
				{
					$controls = '<div class="controls">'.anchor('page/edit/'.$top['id'], img('img/edit_icon_black.png'), array('class' => 'edit')).'</div>';
				}
				else
				{
					$controls = null;
				}
				$menu[$top['id']][] = $controls.anchor('page/view/'.$top['url'], $top['title'], array('class' => 'top menu_anchor', 'id' => $top['url']));
			
			}
			foreach ($mids as $mid)
			{
				if ($this->ci->userdata['group']['name'] == 'Admin')
				{
					$controls = '<div class="controls">'.anchor('page/edit/'.$mid['id'], img('img/edit_icon_black.png'), array('class' => 'edit')).'</div>';
				}
				else
				{
					$controls = null;
				}
				$menu[$mid['parent_id']]['children'][$mid['id']][] = $controls.anchor('page/view/'.$mid['url'], $mid['title'], array('class' => 'mid menu_anchor', 'id' => $mid['url']));
			}
			foreach ($bots as $bot)
			{
				if ($this->ci->userdata['group']['name'] == 'Admin')
				{
					$controls = '<div class="controls">'.anchor('page/edit/'.$bot['id'], img('img/edit_icon_black.png'), array('class' => 'edit')).'</div>';
				}
				else
				{
					$controls = null;
				}
				$menu[$parent_id]['children'][$id]['children'][] = $controls.anchor('page/view/'.$bot['url'], $bot['title'], array('class' => 'bot menu_anchor', 'id' => $bot['url']));
			}
		
	    //echo '<pre>'; print_r($menu); echo '</pre>';
	    return $this->ci->common_class->r_implode('', $menu);
	}
}