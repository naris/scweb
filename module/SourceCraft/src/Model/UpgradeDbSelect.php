<?php
namespace SourceCraft\Model;

use InvalidArgumentException;
use RuntimeException;

use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\Adapter\Driver\ResultInterface;
use Laminas\Db\Sql\Sql;

//use Laminas\Hydrator\ReflectionHydrator;
use Laminas\Hydrator\HydratorInterface;
use Laminas\Db\ResultSet\HydratingResultSet;
use Laminas\Db\ResultSet\ResultSet;

use Laminas\Paginator\Adapter\LaminasDb\DbSelect;
use Laminas\Paginator\Paginator;

use SourceCraft\Model\UpgradeDbInterface;

class UpgradeDbSelect implements UpgradeDbInterface
{
    /**
     * @var AdapterInterface
     */
    private $db;

    /**
     * @var HydratorInterface
     */
    private $hydrator;

    /**
     * @var Upgrade
     */
    private $prototype;

    /**
     * @param AdapterInterface $db
     */
    public function __construct(AdapterInterface $db,
                                HydratorInterface $hydrator,
                                Upgrade $prototype)
    {
        $this->db        = $db;
        $this->hydrator  = $hydrator;
        $this->prototype = $prototype;
    }

    /**
     * {@inheritDoc}
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function fetchUpgradesForRace($raceId, $paginated = false)
	{
        $sql    = new Sql($this->db);
		$select = $this->getSelect($sql)
			->where(['u.race_ident' => $raceId])
			->order(['race_ident', 'upgrade']);

		//print "sql=".$select->getSqlString();
        return $this->fetchSelect($sql, $select, $paginated);
	}

    /**
     * {@inheritDoc}
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
	public function fetchUpgradesForPlayer($playerId, $paginated=false)
	{
        $sql    = new Sql($this->db);
		$select = $this->getSelect($sql);
        $select = $select->join(['pr' => 'sc_player_races'],
								'pr.race_ident = u.race_ident and pr.player_ident = pr.player_ident',
								['xp', 'level'], $select::JOIN_LEFT)
						 ->join(['pu' => 'sc_player_upgrades'],
								'pu.race_ident = u.race_ident and pu.upgrade = u.upgrade and pu.player_ident = pr.player_ident',
                                ['upgrade_level'], $select::JOIN_LEFT)
                         ->where(['pr.player_ident' => $playerId])
                         ->order('pr.race_ident', 'pr.upgrade');

		//print "sql=".$select->getSqlString();
        return $this->fetchSelect($sql, $select, $paginated);
	}

    private function fetchSelect($sql, $select, $paginated = false)
    {
        if ($paginated)
        {
            return $this->fetchPaginatedResults($sql, $select);
        }
        else
        {
            $stmt   = $sql->prepareStatementForSqlObject($select);
            $result = $stmt->execute();
    
            if (! $result instanceof ResultInterface || ! $result->isQueryResult())
            {
                return [];
            }
        
            $resultSet = new HydratingResultSet($this->hydrator, $this->prototype);
            $resultSet->initialize($result);
            return $resultSet;
        }
    }

    private function fetchPaginatedResults($sql, $select)
    {
        // Create a new result set based on the Album entity:
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype($this->prototype);

        // Create a new pagination adapter object:
        $paginatorAdapter = new DbSelect(
            // our configured select object:
            $select,
            // the adapter to run it against:
            $sql,
            // the result set to hydrate:
            $resultSetPrototype
        );

        $paginator = new Paginator($paginatorAdapter);
        return $paginator;
    }

    private function getSelect($sql)
	{
        $select = $sql->select();
		return $select->from(['u' => 'sc_upgrades'])
            ->columns(['race_ident', 'upgrade', 'long_name', 'image',
				      'description', 'invoke', 'bind', 'category',
				      'required_level', 'max_level', 'cost_crystals',
				      'cost_vespene', 'energy', 'accumulated',
				      'recurring_energy', 'crystals', 'vespene',
				      'cooldown']);
	}

    
/***************************************************************************************
	public function getUpgradeListForFaction($factionId, $fetch=false)
	{
		$select = $this->select()
			->setIntegrityCheck(false)
			->from(array('u' => 'sc_upgrades'),
				array('u.upgrade', 'u.long_name', 'u.image',
				      'description' 	 => 'u.description',
				      'invoke' 			 => 'u.invoke',
				      'bind' 			 => 'u.bind',
				      'category' 		 => 'u.category',
				      'required_level'	 => 'u.required_level',
				      'max_level'		 => 'u.max_level',
				      'cost_crystals'	 => 'u.cost_crystals',
				      'cost_vespene'	 => 'u.cost_vespene',
				      'energy'			 => 'u.energy',
				      'accumulated'		 => 'u.accumulated',
				      'recurring_energy' => 'u.recurring_energy',
				      'crystals'		 => 'u.crystals',
				      'vespene'			 => 'u.vespene',
				      'cooldown'		 => 'u.cooldown'))
			->join(array('r' => 'sc_races'),
			      'u.race_ident = r.race_ident',
			      array("r.race_ident"))
			->where('r.faction = ?', $factionId)
			->order(array('u.race_ident', 'u.upgrade'));

		return $fetch ? $this->fetchAll($select) : $select;
	}

	public function getUpgradeListForRace($race_ident, $fetch=false)
	{
		$select = $this->select()
			->from(array('u' => 'sc_upgrades'),
				array('u.race_ident', 'u.upgrade', 'u.long_name', 'u.image',
				      'description'		 => 'u.description',
				      'invoke'			 => 'u.invoke',
				      'bind'			 => 'u.bind',
				      'category'		 => 'u.category',
				      'required_level'	 => 'u.required_level',
				      'max_level'		 => 'u.max_level',
				      'cost_crystals'	 => 'u.cost_crystals',
				      'cost_vespene'	 => 'u.cost_vespene',
				      'energy'			 => 'u.energy',
				      'accumulated'		 => 'u.accumulated',
				      'recurring_energy' => 'u.recurring_energy',
				      'crystals'		 => 'u.crystals',
				      'vespene'			 => 'u.vespene',
				      'cooldown'		 => 'u.cooldown'))
			->where('u.race_ident = ?', $race_ident)
			->order(array('u.race_ident', 'u.upgrade'));

		return $fetch ? $this->fetchAll($select) : $select;		
	}

	public function getUpgradeListForPlayer($player_ident, $fetch=false)
	{
		$select = $this->select()
			->setIntegrityCheck(false)
			->from(array('pr' => 'sc_player_races'))
			->join(array('u' => 'sc_upgrades'),
				      'u.race_ident = pr.race_ident',
				      array('u.race_ident', 'u.upgrade', 'u.long_name', 'u.image',
			       	    'description'	   => 'u.description',
			       	    'invoke'		   => 'u.invoke',
			       	    'bind'			   => 'u.bind',
					    'category'		   => 'u.category',
					    'required_level'   => 'u.required_level',
					    'max_level'		   => 'u.max_level',
					    'cost_crystals'	   => 'u.cost_crystals',
					    'cost_vespene'	   => 'u.cost_vespene',
					    'energy'		   => 'u.energy',
					    'accumulated'	   => 'u.accumulated',
					    'recurring_energy' => 'u.recurring_energy',
					    'crystals'		   => 'u.crystals',
					    'vespene'		   => 'u.vespene',
					    'cooldown'		   => 'u.cooldown'))
			->joinLeft(array('pu' => 'sc_player_upgrades'),
					  'pu.race_ident = u.race_ident and pu.upgrade = u.upgrade and pu.player_ident = pr.player_ident',
					  array('pu.upgrade_level'))
			->where('pr.player_ident = ?', $player_ident)
			->order(array('u.race_ident', 'u.upgrade'));

		return $fetch ? $this->fetchAll($select) : $select;		
	}
 ***************************************************************************************/    
}