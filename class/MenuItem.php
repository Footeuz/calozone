<?php

/**
 * MenuItem : All links for one menu
 *
 * @author Stephanie Michel <s.michel@animaute.com>
 */
class MenuItem extends Root {
    const TBNAME = TABLEPREFIX.'_menu_item';

    static $columns = array(
        'id' => 'int(11) NOT NULL',
        'name' => 'varchar(255) NOT NULL',
        'link_url' => 'varchar(255) NOT NULL',
        'page_id' => 'int(8) NOT NULL DEFAULT 0',
        'categoryproduct_id' => 'int(8) NOT NULL DEFAULT 0',
        'blank' => 'int(1) NOT NULL DEFAULT 0',
        'menu_id' => 'int(8) NOT NULL DEFAULT 0',
        'position' => 'int(8) NOT NULL DEFAULT 0',
        'parent_id' => 'int(8) NOT NULL DEFAULT 0'
    );

    /**
     * menu's name
     * @var string
     */
    var $name = '';
    /**
     * menu's item's is a url
     * @var string
     */
    var $link_url = '';
    /**
     * menu's item is a page link
     * @var integer
     */
    var $page_id = 0;
    /**
     * menu's item is a product's category link
     * @var integer
     */
    var $categoryproduct_id = 0;
    /**
     * menu's item link should be open in a blank page or not
     * @var integer
     */
    var $blank = 0;
    /**
     * menu's item is for this menu
     * @var integer
     */
    var $menu_id = 0;
    /**
     * menu's item position in the menu
     * @var integer
     */
    var $position = 0;
    /**
     * menu's item parent id
     * @var integer
     */
    var $parent_id = 0;

    /**
     * Get the name of one instance
     * @param int $id
     * @return string
     */
    static function getName($id){
        $obj = new MenuItem($id);
        return $obj->name;
    }
    /**
     * Get the num of one instance
     * @param int $id
     * @return int
     */
    static function getNum($id){
        $num = 0;
        if ($id>0) {
            $obj = new MenuItem($id);
            if ($obj->page_id > 0) {
                $page = new Page($obj->page_id);
                $num = $page->id;
            } else if ($obj->categoryproduct_id > 0) {
                $category = new ProductCategory($obj->categoryproduct_id);
                $num = $category->id;
            }
        }
        return $num;
    }

    /**
     * Get stack for a specific menu
     * @param int $id Menu id
     * @param int $parent_id Menu items level
     * @return \MenuItem[]
     */
    public static function getStackMenu($id, $parent_id = 0)
    {
        $items = array();
        $where = array('menu_id'=>$id, 'parent_id'=>$parent_id);
        $result = SQL::select(self::TBNAME, $where, [], 'position ASC');
        if ($result) {
            while ($item = $result->fetch_assoc()) {
                if($parent_id == 0) $item['childs'] = MenuItem::getStackMenu($id, $item['id']);
                $items[$item['id']] = $item;
            }
        }
        return $items;
    }

    /**
     * Get number of items for a specific menu
     * @param int $id Menu id
     * @return integer
     */
    public static function getCountItemsMenu($id)
    {
        $items = array();
        $where = array('menu_id'=>$id);
        $result = SQL::select(self::TBNAME, $where, ['count(*) as cpt'], '');
        if ($result) {
            while ($item = $result->fetch_assoc()) {
                return $item['cpt'];
            }
        }
        return false;
    }

    /**
     * Get link for this item
     * @param int $id
     * @return string
     */
    public static function getLink($id=0)
    {
        if ($id>0) {
            $obj = new MenuItem($id);

            $link = URL;
            if (!empty($obj->link_url)) {
                if (substr($obj->link_url, 0, 4) == 'http') $link = $obj->link_url; else $link .= $obj->link_url;
            } else if ($obj->page_id > 0) {
                $page = new Page($obj->page_id);
                $link .= 'page/' . $page->slug . '-' . $page->id;
            } else if ($obj->categoryproduct_id > 0) {
                $category = new ProductCategory($obj->categoryproduct_id);
                $link .= 'boutique/categorie/' . $category->slug . '-' . $category->id;
            }
            return $link;
        } else {
            return false;
        }
    }
}
