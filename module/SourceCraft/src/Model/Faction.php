<?php

/**
 * Factions
 *  
 * @author wilsonmu
 * @version 
 */
namespace SourceCraft\Model;

#require_once ('App_Db_Table_Abstract.php');

#class Faction extends App_Db_Table_Abstract
class Faction
{
	private $faction;
	private $long_name;
	private $description;
	private $image;
	private $add_date;

	/**
     * @param string      $faction
     * @param string      $long_name
     * @param string      $description
     * @param string      $image
     * @param timestamp   $add_date
     */
    public function __construct($faction='', $long_name='', $description='',
								$image='', $add_date=null)
    {
        $this->faction     = $faction;
        $this->long_name   = $long_name;
        $this->description = $description;
        $this->image       = $image;
        $this->add_date    = $add_date;
    }

    public function exchangeArray(array $data)
    {
        $this->faction          = !empty($data['faction'])     ? $data['faction']     : null;
        $this->long_name        = !empty($data['long_name'])   ? $data['long_name']   : null;
        $this->parent_name      = !empty($data['parent_name']) ? $data['parent_name'] : null;
        $this->description      = !empty($data['description']) ? $data['description'] : null;
        $this->image            = !empty($data['image'])       ? $data['image']       : null;
        $this->add_date         = !empty($data['add_date'])    ? $data['add_date']    : null;
    }
	
    public function getArrayCopy()
    {
        return [
            'faction'     => $this->faction,
            'long_name'   => $this->long_name,
            'description' => $this->description,
            'image'       => $this->image,
            'add_date'    => $this->add_date,
        ];
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->faction;
    }

    /**
     * @return string
     */
    public function getFaction()
    {
        return $this->faction;
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
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @return timestamp|null
     */
    public function getAddDate()
    {
        return $this->add_date;
    }
}
