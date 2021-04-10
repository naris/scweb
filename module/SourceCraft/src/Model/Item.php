<?php

/**
 * Race
 *  
 * @author wilsonmu
 * @version 
 */

namespace SourceCraft\Model;

#require_once ('App_Db_Table_Abstract.php');
#class Item extends App_Db_Table_Abstract

class Item
{
	private $item_ident;
	private $item_name;
	private $long_name;
	private $category;
	private $description;
	private $crystals;
	private $vespene;
	private $max;
	private $required_level;
	private $image;
	private $add_date;

    /**
     * @param int         $item_ident
     * @param string      $item_name
     * @param string      $long_name
     * @param string      $category
     * @param string      $description
     * @param int         $crystals
     * @param int         $vespene
     * @param int         $max
     * @param int         $required_level
     * @param string      $image
     * @param timestamp   $add_date
     */
    public function __construct($item_ident=0, $item_name=null, $long_name=null,
	                            $category=null, $description=null, $crystals=0,
								$vespene=0, $max=0, $required_level=0,
								$image=null, $add_date=null)
    {
        $this->item_ident         = $item_ident;
        $this->item_name          = $item_name;
        $this->long_name          = $long_name;
        $this->category           = $category;
        $this->description        = $description;
        $this->crystals           = $crystals;
        $this->vespene            = $vespene;
        $this->max                = $max;
        $this->required_level     = $required_level;
        $this->image              = $image;
        $this->add_date           = $add_date;
    }

    public function exchangeArray(array $data)
    {
        $this->item_ident         = !empty($data['item_ident'])         ? $data['item_ident']         : null;
        $this->upgrade            = !empty($data['upgrade'])            ? $data['upgrade']            : null;
        $this->item_name          = !empty($data['item_name'])          ? $data['item_name']          : null;
        $this->long_name          = !empty($data['long_name'])          ? $data['long_name']          : null;
        $this->category           = !empty($data['category'])           ? $data['category']           : null;
        $this->description        = !empty($data['description'])        ? $data['description']        : null;
        $this->crystals           = !empty($data['crystals'])           ? $data['crystals']           : null;
        $this->vespene            = !empty($data['vespene'])            ? $data['vespene']            : null;
        $this->max                = !empty($data['max'])                ? $data['max']                : null;
        $this->required_level     = !empty($data['required_level'])     ? $data['required_level']     : null;
        $this->image              = !empty($data['image'])              ? $data['image']              : null;
        $this->add_date           = !empty($data['add_date'])           ? $data['add_date']           : null;
    }
	
    public function getArrayCopy()
    {
        return [
            'item_ident'         => $this->item_ident,
            'item_name'          => $this->item_name,
            'long_name'          => $this->long_name,
			'category'           => $this->category,
            'description'        => $this->description,
            'crystals'           => $this->crystals,
            'vespene'            => $this->vespene,
            'max'                => $this->max,
            'required_level'     => $this->required_level,
            'image'              => $this->image,
            'add_date'           => $this->add_date,
        ];
    }

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->item_ident;
    }

    /**
     * @return string
     */
    public function getItemName()
    {
        return $this->item_name;
    }

    /**
     * @return string
     */
    public function getLongName()
    {
        return $this->long_name;
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return int
     */
    public function getCrystals()
    {
        return $this->crystals;
    }

    /**
     * @return int
     */
    public function getVespene()
    {
        return $this->vespene;
    }

    /**
     * @return int
     */
    public function getMax()
    {
        return $this->max;
    }

    /**
     * @return int
     */
    public function getRequiredLevel()
    {
        return $this->required_level;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @return timestamp
     */
    public function getAddDate()
    {
        return $this->add_date;
    }
}
