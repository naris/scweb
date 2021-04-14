<?php

/**
 * PlayerTech
 *  
 * @author wilsonmu
 * @version 
 */

namespace SourceCraft\Model;

#require_once 'App_Db_Table_Abstract.php';
#class PlayerTech extends App_Db_Table_Abstract

class PlayerTech
{
	private $player_ident;
	private $faction;
	private $tech_count;
	private $tech_level;

	// Columns from joins to other tables
	private $long_name;
	private $image;

    /**
     * @param string      $faction
     * @param int         $tech_count
     * @param int         $tech_level
	 * 
     * @param string      $image
     */
    public function __construct($faction=null, $tech_count=null, $tech_level=null,
								$long_name=null, $image=null)
    {
        $this->player_ident = $id;
        $this->faction      = $faction;
        $this->tech_count   = $tech_count;
        $this->tech_level   = $tech_level;

        $this->long_name    = $long_name;
        $this->image        = $image;
    }

    public function exchangeArray(array $data)
    {
        $this->player_ident = !empty($data['player_ident']) ? $data['player_ident'] : null;
        $this->tech_count   = !empty($data['tech_count'])   ? $data['tech_count']   : null;
        $this->tech_level   = !empty($data['tech_level'])   ? $data['tech_level']   : null;

        $this->long_name    = !empty($data['long_name'])    ? $data['long_name']    : null;
        $this->image        = !empty($data['image'])        ? $data['image']        : null;
    }
	
    public function getArrayCopy()
    {
        return [
            'player_ident' => $this->player_ident,
            'faction'      => $this->faction,
            'tech_count'   => $this->tech_count,
            'tech_level'   => $this->tech_level,

            'long_name'    => $this->long_name,
			'image'        => $this->image,
        ];
    }

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->player_ident;
    }

    /**
     * @return string
     */
    public function getFaction()
    {
        return $this->faction;
    }

    /**
     * @return int
     */
    public function getTechCount()
    {
        return $this->tech_count;
    }

    /**
     * @return int
     */
    public function getTechLevel()
    {
        return $this->tech_level;
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
    public function getImage()
    {
        return $this->image;
    }

/***************************************************************************************
	protected $_use_adapter = "sc";
	protected $_name = "sc_player_tech";
	protected $_primary = array("player_ident", "faction");
	protected $_cols = array(
		'player_ident'  => 'player_ident',
		'faction'    	=> 'faction',
		'tech_count'    => 'tech_count',
		'tech_level'    => 'tech_level'
	);
 ***************************************************************************************/
}
