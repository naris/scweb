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
	private $race_ident;
	private $race_name;
	private $long_name;
	private $parent_name;
	private $faction;
	private $type;
	private $description;
	private $image;
	private $required_level;
	private $tech_level;
	private $add_date;

	// Columns from joins to other tables
	private $faction_name;
	private $parent_long_name;

    private $xp;
	private $level;

    /**
     * @param string      $race_name
     * @param string      $long_name
     * @param string      $parent_name
     * @param string      $faction
     * @param string      $type
     * @param string      $description
     * @param string      $image
     * @param int         $required_level
     * @param int         $tech_level
     * @param timestamp   $add_date
     * @param string|null $faction_name
     * @param string|null $parent_long_name
     * @param int|null    $id
     */
    public function __construct($race_name=null, $long_name=null, $parent_name=null,
                                $faction=null, $type=null, $description=null, $image=null,
                                $required_level=null, $tech_level=null, $add_date=null,
                                $faction_name=null, $parent_long_name=null,
                                $xp=null, $level=null, $id=null)
    {
        $this->race_ident       = $id;
        $this->race_name        = $race_name;
        $this->long_name        = $long_name;
        $this->parent_name      = $parent_name;
        $this->faction          = $faction;
        $this->type             = $type;
        $this->description      = $description;
        $this->image            = $image;
        $this->required_level   = $required_level;
        $this->tech_level       = $tech_level;
        $this->add_date         = $add_date;

        $this->faction_name     = $faction_name;
        $this->parent_long_name = $parent_long_name;

        $this->xp               = $xp;
        $this->level            = $level;
    }

    public function exchangeArray(array $data)
    {
        $this->race_ident       = !empty($data['race_ident'])       ? $data['race_ident']       : null;
        $this->race_name        = !empty($data['race_name'])        ? $data['race_name']        : null;
        $this->long_name        = !empty($data['long_name'])        ? $data['long_name']        : null;
        $this->parent_name      = !empty($data['parent_name'])      ? $data['parent_name']      : null;
        $this->faction          = !empty($data['faction'])          ? $data['faction']          : null;
        $this->type             = !empty($data['type'])             ? $data['type']             : null;
        $this->description      = !empty($data['description'])      ? $data['description']      : null;
        $this->image            = !empty($data['image'])            ? $data['image']            : null;
        $this->required_level   = !empty($data['required_level'])   ? $data['required_level']   : null;
        $this->tech_level       = !empty($data['tech_level'])       ? $data['tech_level']       : null;
        $this->add_date         = !empty($data['add_date'])         ? $data['add_date']         : null;

        $this->faction_name     = !empty($data['faction_name'])     ? $data['faction_name']     : null;
        $this->parent_long_name = !empty($data['parent_long_name']) ? $data['parent_long_name'] : null;

        $this->xp               = !empty($data['xp'])               ? $data['xp']               : null;
        $this->level            = !empty($data['level'])            ? $data['level']            : null;
    }
	
    public function getArrayCopy()
    {
        return [
            'race_ident'       => $this->race_ident,
            'race_name'        => $this->race_name,
            'long_name'        => $this->long_name,
            'parent_name'      => $this->parent_name,
            'faction'          => $this->faction,
			'type'             => $this->type,
            'description'      => $this->description,
            'image'            => $this->image,
            'required_level'   => $this->required_level,
            'tech_level'       => $this->tech_level,
            'add_date'         => $this->add_date,
			
            'faction_name'     => $this->faction_name,
            'parent_long_name' => $this->parent_long_name,
			
            'xp'               => $this->xp,
            'level'            => $this->level,
        ];
    }

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->race_ident;
    }

    /**
     * @return string
     */
    public function getRaceName()
    {
        return $this->race_name;
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
    public function getParentName()
    {
        return $this->parent_name;
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
    public function getType()
    {
        return $this->type;
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
     * @return int
     */
    public function getRequiredLevel()
    {
        return $this->required_level;
    }

    /**
     * @return int
     */
    public function getTechLevel()
    {
        return $this->tech_level;
    }

    /**
     * @return timestamp
     */
    public function getAddDate()
    {
        return $this->add_date;
    }

    /**
     * @return string
     */
    public function getFactionName()
    {
        return $this->faction_name;
    }

    /**
     * @return string
     */
    public function getParentLongName()
    {
        return $this->parent_long_name;
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
	protected $_name = 'sc_races';
	protected $_primary = array("race_ident");
	protected $_cols = array(
		'race_ident'    	=> 'race_ident',
		'race_name'  		=> 'race_name',
		'long_name'  		=> 'long_name',
		'parent_name'  		=> 'parent_name',
		'faction'  		    => 'faction',
		'type'  		    => 'type',
		'description'  		=> 'description',
		'image'  		    => 'image',
		'required_level'  	=> 'required_level',
		'tech_level'  		=> 'tech_level',
		'add_date'		    => 'add_date'
	);
 ***************************************************************************************/
}
