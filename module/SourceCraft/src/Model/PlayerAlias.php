<?php

/**
 * PlayerAlias
 *  
 * @author wilsonmu
 * @version 
 */

namespace SourceCraft\Model;

#require_once 'App_Db_Table_Abstract.php';
#class PlayerAlias extends App_Db_Table_Abstract

class PlayerAlias
{
	private $player_ident;
	private $steamid;
	private $name;
	private $last_used;

    /**
     * @param string      $steamid
     * @param string      $name
     * @param timestamp   $last_used
     * @param int|null    $id
     */
    public function __construct($steamid=null, $name=null, $last_used=null,
                                $id=null)
    {
        $this->player_ident = $id;
        $this->steamid      = $steamid;
        $this->name         = $name;
        $this->last_used    = $last_used;
    }

    public function exchangeArray(array $data)
    {
        $this->player_ident = !empty($data['player_ident']) ? $data['player_ident'] : null;
        $this->steamid      = !empty($data['steamid'])      ? $data['steamid']      : null;
        $this->name         = !empty($data['name'])         ? $data['name']         : null;
        $this->last_used    = !empty($data['last_used'])    ? $data['last_used']    : null;
    }
	
    public function getArrayCopy()
    {
        return [
            'player_ident' => $this->player_ident,
            'steamid'      => $this->steamid,
            'name'         => $this->name,
            'last_used'    => $this->last_used,
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
    public function getSteamId()
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
     * @return timestamp
     */
    public function getLastUsed()
    {
        return $this->last_used;
    }

/***************************************************************************************
	protected $_use_adapter = "sc";
	protected $_name = "sc_player_alias";
	protected $_primary = array("player_ident", "steamid", "name");
	protected $_cols = array(
		'player_ident'  => 'player_ident',
		'steamid'    	=> 'steamid',
		'name'       	=> 'name',
		'last_used'     => 'last_used'
	);
 ***************************************************************************************/
}
