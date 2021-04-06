<?php

/**
 * Race
 *  
 * @author wilsonmu
 * @version 
 */

namespace SourceCraft\Model;

#use DomainException;
#use Laminas\Filter\StringTrim;
#use Laminas\Filter\StripTags;
#use Laminas\Filter\ToInt;
#use Laminas\InputFilter\InputFilter;
#use Laminas\InputFilter\InputFilterAwareInterface;
#use Laminas\InputFilter\InputFilterInterface;
#use Laminas\Validator\StringLength;

#require_once ('App_Db_Table_Abstract.php');

#class Race extends App_Db_Table_Abstract
#class Race implements InputFilterAwareInterface
class Race
{
	/*
	protected $_use_adapter = "sc";
	protected $_name = 'sc_races';
	protected $_primary = array("race_ident");
	protected $_cols = array(
		'race_ident'    	=> 'race_ident',
		'race_name'  		=> 'race_name',
		'long_name'  		=> 'long_name',
		'parent_name'  		=> 'parent_name',
		'faction'  		=> 'faction',
		'type'  		=> 'type',
		'description'  		=> 'description',
		'image'  		=> 'image',
		'required_level'  	=> 'required_level',
		'tech_level'  		=> 'tech_level',
		'add_date'		=> 'add_date'
	);
	*/
	
	public $race_ident;
	public $race_name;
	public $long_name;
	public $parent_name;
	public $faction;
	public $type;
	public $description;
	public $image;
	public $required_level;
	public $tech_level;
	public $add_date;

    public function exchangeArray(array $data)
    {
        $this->race_ident     = !empty($data['race_ident'])     ? $data['race_ident']     : null;
        $this->race_name      = !empty($data['race_name'])      ? $data['race_name']      : null;
        $this->parent_name    = !empty($data['parent_name'])    ? $data['parent_name']    : null;
        $this->faction        = !empty($data['faction'])        ? $data['faction']        : null;
        $this->type           = !empty($data['type'])           ? $data['type']           : null;
        $this->description    = !empty($data['description'])    ? $data['description']    : null;
        $this->image          = !empty($data['image'])          ? $data['image']          : null;
        $this->required_level = !empty($data['required_level']) ? $data['required_level'] : null;
        $this->tech_level     = !empty($data['tech_level'])     ? $data['tech_level']     : null;
        $this->add_date       = !empty($data['add_date'])       ? $data['add_date']       : null;
    }
	
    public function getArrayCopy()
    {
        return [
            'race_ident'     => $this->race_ident,
            'race_name'      => $this->race_name,
            'parent_name'    => $this->parent_name,
            'faction'        => $this->faction,
            'type'           => $this->type,
            'description'    => $this->description,
            'image'          => $this->image,
            'required_level' => $this->required_level,
            'tech_level'     => $this->tech_level,
            'add_date'       => $this->add_date,
        ];
    }

/***************************************************************************************
	public function getRaceList($fetch=false)
	{
		$select = $this->getRaceSelect()
			->order('long_name');

		return $fetch ? $this->fetchAll($select) : $select;		
	}

	public function getRaceListForFaction($factionId, $fetch=false)
	{
		$select = $this->getRaceSelect()
			->where('r.faction = ?', $factionId)
			->order('long_name');

		return $fetch ? $this->fetchAll($select) : $select;		
	}

	public function getRaceListForPlayer($player_ident, $fetch=false)
	{
		$select = $this->getRaceSelect()
			->join(array('pr' => 'sc_player_races'),
			      	     'pr.race_ident = r.race_ident',
			      	     array('xp', 'level'))
			->where('pr.player_ident = ?', $player_ident)
			->order('long_name');

		return $fetch ? $this->fetchAll($select) : $select;		
	}

	public function getRaceListForName($name, $fetch=false)
	{
		$select = $this->getRaceSelect()
			->where('r.race_name like ?', '%' . $name . '%')
			->order('long_name');

		return $fetch ? $this->fetchAll($select) : $select;		
	}

	public function getRaceForIdent($ident)
	{
		$select = $this->getRaceSelect()
			->where('r.race_ident = ?', $ident);

		return $this->fetchRow($select);
	}

	public function getRaceForName($name)
	{
		$select = $this->getRaceSelect()
			->where('r.race_name like ?', '%' . $name . '%');

		return $this->fetchRow($select);
	}

	private function getRaceSelect()
	{
		return $this->select()
			->setIntegrityCheck(false)
			->from(array('r' => 'sc_races'),
				array('race_ident', 'long_name', 'faction', 'type',
			              'parent_name', 'image', 'required_level', 'tech_level',
			       	      'description' => 'r.description'))
			->joinLeft(array('f' => 'sc_factions'),
				'f.faction = r.faction',
				array('faction_name' => 'f.long_name'))
			->joinLeft(array('rp' => 'sc_races'),
				'rp.race_name = r.parent_name',
				array('parent_long_name' => 'rp.long_name'));
	}
	
	public function selectPlayerRaces($ident)
	{
		return $this->getRaceSelect()
			    ->joinLeft(array('sc_player_races', 'pr'),
				       'r.player_ident == pr.player_ident',
				       array('pr.xp','pr.level'))
			    ->where('player_ident = ?', $ident)
			    ->order('long_name');
	}
 ***************************************************************************************/
}
