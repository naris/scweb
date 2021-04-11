<?php

/**
 * Player
 *  
 * @author wilsonmu
 * @version 
 */

namespace SourceCraft\Model;

#require_once ('App_Db_Table_Abstract.php');
#class Player extends App_Db_Table_Abstract
class Player
{
	private $player_ident;
	private $steamid;
	private $name;
	private $race_ident;
	private $crystals;
	private $vespene;
	private $settings;
	private $last_update;
	private $username;

    /**
     * @param string      $steamid
     * @param string      $name
     * @param int         $race_ident
     * @param int         $crystals
     * @param int         $vespene
     * @param int         $settings
     * @param timestamp   $last_update
     * @param string|null $faction_name
     * @param string|null $parent_long_name
     * @param int|null    $id
     */
    public function __construct($steamid=null, $name=null, $race_ident=null,
                                $crystals=null, $vespene=null, $settings=null,
                                $last_update=null, $username=null, $id=null)
    {
        $this->player_ident     = $id;
        $this->steamid          = $steamid;
        $this->name             = $name;
        $this->race_ident       = $race_ident;
        $this->crystals         = $crystals;
        $this->vespene          = $vespene;
        $this->settings         = $settings;
        $this->last_update      = $last_update;
        $this->username         = $username;
    }

    public function exchangeArray(array $data)
    {
        $this->player_ident     = !empty($data['player_ident'])     ? $data['player_ident']     : null;
        $this->steamid          = !empty($data['steamid'])          ? $data['steamid']          : null;
        $this->name             = !empty($data['name'])             ? $data['name']             : null;
        $this->race_ident       = !empty($data['race_ident'])       ? $data['race_ident']       : null;
        $this->crystals         = !empty($data['crystals'])         ? $data['crystals']         : null;
        $this->vespene          = !empty($data['vespene'])          ? $data['vespene']          : null;
        $this->settings         = !empty($data['settings'])         ? $data['settings']         : null;
        $this->last_update      = !empty($data['last_update'])      ? $data['last_update']      : null;
        $this->username         = !empty($data['username'])         ? $data['username']         : null;
    }
	
    public function getArrayCopy()
    {
        return [
            'player_ident'     => $this->player_ident,
            'steamid'          => $this->steamid,
            'name'             => $this->name,
            'race_ident'       => $this->race_ident,
            'crystals'         => $this->crystals,
            'vespene'          => $this->vespene,
            'settings'         => $this->settings,
            'last_update'      => $this->last_update,
            'username'         => $this->username,
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
    public function getSteamid()
    {
        return $this->steamid;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getRaceIdent()
    {
        return $this->race_ident;
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
    public function getSettings()
    {
        return $this->settings;
    }

    /**
     * @return timestamp
     */
    public function getLastUpdate()
    {
        return $this->last_update;
    }

    /**
     * @return string
     */
    public function getUserName()
    {
        return $this->username;
    }

/***************************************************************************************
	protected $_use_adapter = "sc";
	protected $_name = "sc_players";
	protected $_primary = "player_ident";
	protected $_sequence = true;
	protected $_cols = array(
		'player_ident'  => 'player_ident',
		'steamid'       => 'steamid',
		'name'        	=> 'name',
		'race_ident'    => 'race_ident',
		'crystals'   	=> 'crystals',
		'vespene'   	=> 'vespene',
		'overall_level' => 'overall_level',
		'settings' 		=> 'settings',
		'last_update' 	=> 'last_update',
		'username'		=> 'username'
	);
 ***************************************************************************************/    
}

?>
