<?php

/**
 * PlayerRace
 *  
 * @author wilsonmu
 * @version 
 */

namespace SourceCraft\Model;

#require_once 'App_Db_Table_Abstract.php';
#class PlayerRace extends App_Db_Table_Abstract

class sc_player_races
{
	private $player_ident;
	private $race_ident;
	private $xp;
	private $level;

    /**
     * @param int         $player_ident
     * @param int         $race_ident
     * @param int         $xp
     * @param int         $level
     */
    public function __construct($player_ident=null, $race_ident=null,
                                $xp=null, $level=null)
    {
        $this->player_ident = $id;
        $this->race_ident   = $race_ident;
        $this->xp           = $xp;
        $this->level        = $level;
    }

    public function exchangeArray(array $data)
    {
        $this->player_ident = !empty($data['player_ident']) ? $data['player_ident'] : null;
        $this->race_ident   = !empty($data['race_ident'])   ? $data['race_ident']   : null;
        $this->xp           = !empty($data['xp'])           ? $data['xp']           : null;
        $this->level        = !empty($data['level'])        ? $data['level']        : null;
    }
	
    public function getArrayCopy()
    {
        return [
            'player_ident' => $this->player_ident,
            'race_ident'   => $this->race_ident,
            'xp'           => $this->xp,
            'level'        => $this->level,
        ];
    }

    /**
     * @return int
     */
    public function getPlayerIdent()
    {
        return $this->player_ident;
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
    public function getXP()
    {
        return $this->xp;
    }

    /**
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

/***************************************************************************************
	protected $_use_adapter = "sc";
	protected $_name = "sc_player_races";
	protected $_primary = array("player_ident", "race_ident");
	protected $_cols = array(
		'player_ident'  => 'player_ident',
		'race_ident'    => 'race_ident',
		''       	    => 'xp',
		'level'        	=> 'level'
	);
 ***************************************************************************************/    
}
