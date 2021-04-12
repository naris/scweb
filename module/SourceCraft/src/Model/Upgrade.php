<?php

/**
 * Upgrade
 *  
 * @author wilsonmu
 * @version 
 */

namespace SourceCraft\Model;

#require_once 'App_Db_Table_Abstract.php';
#class Upgrade extends App_Db_Table_Abstract

class Upgrade
{
	private $race_ident;
	private $upgrade;
	private $category;
	private $upgrade_name;
	private $long_name;
	private $description;
	private $invoke;
	private $bind;
	private $image;
	private $required_level;
	private $max_level;
	private $cost_crystals;
	private $cost_vespene;
	private $energy;
	private $accumulated;
	private $recurring_energy;
	private $crystals;
	private $vespene;
	private $cooldown;
	private $add_date;

	// Columns from joins to other tables
    private $upgrade_level;

    /**
     * @param int         $race_ident
     * @param int         $upgrade
     * @param int         $category
     * @param string      $upgrade_name
     * @param string      $long_name
     * @param string      $description
     * @param string      $invoke
     * @param string      $bind
     * @param string      $image
     * @param int         $required_level
     * @param int         $max_level
     * @param int         $cost_crystals
     * @param int         $cost_vespene
     * @param int         $energy
     * @param int         $accumulated
     * @param int         $recurring_energy
     * @param int         $recurring_interval
     * @param int         $crystals
     * @param int         $vespene
     * @param int         $cooldown
     * @param timestamp   $add_date
     * @param int         $upgrade_level
     */
    public function __construct($race_ident=null, $upgrade=null, $category=null,
	                            $upgrade_name=null, $long_name=null,
								$description=null, $invoke=null, $bind=null,
								$image=null, $required_level=null, $max_level=null,
                                $cost_crystals=null, $cost_vespene=null, $energy=null,
								$accumulated=null, $recurring_energy=null,
								$recurring_interval=null, $crystals=null,
								$vespene=0, $cooldown=null, $add_date=null,
                                $upgrade_level=null)
    {
        $this->race_ident         = $race_ident;
        $this->upgrade            = $upgrade;
        $this->category           = $category;
        $this->upgrade_name       = $upgrade_name;
        $this->long_name          = $long_name;
        $this->description        = $description;
        $this->invoke             = $invoke;
        $this->bind               = $bind;
        $this->image              = $image;
        $this->required_level     = $required_level;
        $this->max_level          = $max_level;
        $this->cost_crystals      = $cost_crystals;
        $this->cost_vespene       = $cost_vespene;
        $this->energy             = $energy;
        $this->accumulated        = $accumulated;
        $this->recurring_energy   = $recurring_energy;
        $this->recurring_interval = $recurring_interval;
        $this->crystals           = $crystals;
        $this->vespene            = $vespene;
        $this->cooldown           = $cooldown;
        $this->add_date           = $add_date;

        $this->upgrade_level      = $upgrade_level;
    }

    public function exchangeArray(array $data)
    {
        $this->race_ident         = !empty($data['race_ident'])         ? $data['race_ident']         : null;
        $this->upgrade            = !empty($data['upgrade'])            ? $data['upgrade']            : null;
        $this->category           = !empty($data['category'])           ? $data['category']           : null;
        $this->upgrade_name       = !empty($data['upgrade_name'])       ? $data['upgrade_name']       : null;
        $this->long_name          = !empty($data['long_name'])          ? $data['long_name']          : null;
        $this->description        = !empty($data['description'])        ? $data['description']        : null;
        $this->invoke             = !empty($data['invoke'])             ? $data['invoke']             : null;
        $this->bind               = !empty($data['bind'])               ? $data['bind']               : null;
        $this->image              = !empty($data['image'])              ? $data['image']              : null;
        $this->required_level     = !empty($data['required_level'])     ? $data['required_level']     : null;
        $this->max_level          = !empty($data['max_level'])          ? $data['max_level']          : null;
        $this->cost_crystals      = !empty($data['cost_crystals'])      ? $data['cost_crystals']      : null;
        $this->cost_vespene       = !empty($data['cost_vespene'])       ? $data['cost_vespene']       : null;
        $this->energy             = !empty($data['energy'])             ? $data['energy']             : null;
        $this->accumulated        = !empty($data['accumulated'])        ? $data['accumulated']        : null;
        $this->recurring_energy   = !empty($data['recurring_energy'])   ? $data['recurring_energy']   : null;
        $this->recurring_interval = !empty($data['recurring_interval']) ? $data['recurring_interval'] : null;
        $this->crystals           = !empty($data['crystals'])           ? $data['crystals']           : null;
        $this->vespene            = !empty($data['vespene'])            ? $data['vespene']            : null;
        $this->cooldown           = !empty($data['cooldown'])           ? $data['cooldown']           : null;
        $this->add_date           = !empty($data['add_date'])           ? $data['add_date']           : null;

        $this->upgrade_level      = !empty($data['upgrade_level'])      ? $data['upgrade_level']      : null;
    }
	
    public function getArrayCopy()
    {
        return [
            'race_ident'         => $this->race_ident,
            'upgrade'            => $this->upgrade,
			'category'           => $this->category,
            'upgrade_name'       => $this->upgrade_name,
            'long_name'          => $this->long_name,
            'description'        => $this->description,
            'invoke'             => $this->invoke,
            'bind'               => $this->bind,
            'image'              => $this->image,
            'required_level'     => $this->required_level,
            'max_level'          => $this->max_level,
            'cost_crystals'      => $this->cost_crystals,
            'cost_vespene'       => $this->cost_vespene,
            'energy'             => $this->energy,
            'accumulated'        => $this->accumulated,
            'recurring_energy'   => $this->recurring_energy,
            'recurring_interval' => $this->recurring_interval,
            'crystals'           => $this->crystals,
            'vespene'            => $this->vespene,
            'cooldown'           => $this->cooldown,
            'add_date'           => $this->add_date,

            'upgrade_level'      => $this->upgrade_level,
        ];
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
    public function getUpgrade()
    {
        return $this->upgrade;
    }

    /**
     * @return int
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @return string
     */
    public function getUpgradeName()
    {
        return $this->upgrade_name;
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
    public function getInvoke()
    {
        return $this->invoke;
    }

    /**
     * @return string
     */
    public function getBind()
    {
        return $this->bind;
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
    public function getMaxLevel()
    {
        return $this->max_level;
    }

    /**
     * @return int
     */
    public function getCostCrystals()
    {
        return $this->cost_crystals;
    }

    /**
     * @return int
     */
    public function getCostVespene()
    {
        return $this->cost_vespene;
    }

    /**
     * @return int
     */
    public function getEnergy()
    {
        return $this->energy;
    }

    /**
     * @return int
     */
    public function getAccumulated()
    {
        return $this->accumulated;
    }

    /**
     * @return int
     */
    public function getRecurringEnergy()
    {
        return $this->recurring_energy;
    }

    /**
     * @return int
     */
    public function getRecurringInterval()
    {
        return $this->recurring_interval;
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
    public function getCooldown()
    {
        return $this->cooldown;
    }

    /**
     * @return timestamp
     */
    public function getAddDate()
    {
        return $this->add_date;
    }

    /**
     * @return int
     */
    public function getUpgradeLevel()
    {
        return $this->upgrade_level;
    }

/***************************************************************************************
	protected $_use_adapter = "sc";
	protected $_name = 'sc_upgrades';
	protected $_primary = array("race_ident", "upgrade");
	protected $_cols = array(
		'race_ident'    	=> 'race_ident',
		'upgrade'  			=> 'upgrade',
		'category'      	=> 'category',
		'upgrade_name'  	=> 'upgrade_name',
		'long_name'  		=> 'long_name',
		'description'		=> 'description',
		'invoke'			=> 'invoke',
		'bind'				=> 'bind',
		'image'				=> 'image',
		'required_level'	=> 'required_level',
		'max_level'			=> 'max_level',
		'cost_crystals'		=> 'cost_crystals',
		'cost_vespene'		=> 'cost_vespene',
		'energy'			=> 'energy',
		'accumulated'		=> 'accumulated',
		'recurring_energy'	=> 'recurring_energy',
		'crystals'			=> 'crystals',
		'vespene'			=> 'vespene',
		'cooldown'			=> 'cooldown',
		'add_date'			=> 'add_date'
	);
 ***************************************************************************************/
}
