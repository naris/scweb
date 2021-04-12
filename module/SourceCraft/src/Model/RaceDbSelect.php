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

use SourceCraft\Model\RaceDbInterface;

class RaceDbSelect implements RaceDbInterface
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
     * @var Race
     */
    private $prototype;

    /**
     * @param AdapterInterface $db
     */
    public function __construct(AdapterInterface $db,
                                HydratorInterface $hydrator,
                                Race $prototype)
    {
        $this->db        = $db;
        $this->hydrator  = $hydrator;
        $this->prototype = $prototype;
    }

    /**
     * {@inheritDoc}
     */
    public function fetchAll($paginated = false)
    {
        $sql    = new Sql($this->db);
        $select = $this->getSelect($sql);

        return $this->fetchSelect($sql, $select, $paginated);
    }

    /**
     * {@inheritDoc}
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function findRace($id)
    {
        $sql    = new Sql($this->db);
        $select = $this->getSelect($sql);
        $select->where(['r.race_ident = ?' => $id]);
    
        $statement = $sql->prepareStatementForSqlObject($select);
        $result    = $statement->execute();
    
        if (! $result instanceof ResultInterface || ! $result->isQueryResult()) {
            throw new RuntimeException(sprintf(
                'Failed retrieving race with identifier "%s"; unknown database error.',
                $id
            ));
        }
    
        $resultSet = new HydratingResultSet($this->hydrator, $this->prototype);
        $resultSet->initialize($result);
        $result = $resultSet->current();
    
        if (! $result) {
            throw new InvalidArgumentException(sprintf(
                'Race with identifier "%s" not found.',
                $id
            ));
        }
    
        return $result;
    }

    /**
     * {@inheritDoc}
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function findRacebyName($name)
    {
        $sql    = new Sql($this->db);
        $select = $this->getSelect($sql);
        $select->where(['r.race_name = ?' => $name]);
    
        $statement = $sql->prepareStatementForSqlObject($select);
        $result    = $statement->execute();
    
        if (! $result instanceof ResultInterface || ! $result->isQueryResult()) {
            throw new RuntimeException(sprintf(
                'Failed retrieving race with name "%s"; unknown database error.',
                $name
            ));
        }
    
        $resultSet = new HydratingResultSet($this->hydrator, $this->prototype);
        $resultSet->initialize($result);
        $result = $resultSet->current();
    
        if (! $result) {
            throw new InvalidArgumentException(sprintf(
                'Race with name "%s" not found.',
                $name
            ));
        }
    
        return $result;
    }

    /**
     * {@inheritDoc}
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
	public function findMatchingRaces($name, $paginated = false)
	{
        $sql    = new Sql($this->db);
        $select = $this->getSelect($sql);
		$select->where(function (Where $where) {
                    $where->like('r.race_name', '%'.$name.'%');
               })
               ->order('long_name');

        return $this->fetchSelect($sql, $select, $paginated);
	}

    /**
     * {@inheritDoc}
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function fetchRacesForFaction($factionId, $paginated = false)
	{
        $sql    = new Sql($this->db);
		$select = $this->getSelect($sql)
			->where(['r.faction' => $factionId])
			->order('long_name');

        return $this->fetchSelect($sql, $select, $paginated);
	}

    /**
     * {@inheritDoc}
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function fetchRacesForPlayer($playerId, $paginated = false)
	{
        $sql    = new Sql($this->db);
		$select = $this->getSelect($sql);
        $select = $select->join(['pr' => 'sc_player_races'],
                                'pr.race_ident = r.race_ident',
                                ['xp', 'level'], $select::JOIN_LEFT)
                         ->where(['pr.player_ident' => $playerId])
                         ->order('long_name');

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
		return $select->from(['r' => 'sc_races'])
            ->columns(['race_ident', 'race_name', 'long_name', 'faction', 'type',
			           'parent_name', 'image', 'required_level', 'tech_level',
			       	   'description'])
			->join(['f' => 'sc_factions'], 'f.faction = r.faction',
				   ['faction_name' => 'long_name'], $select::JOIN_LEFT)
			->join(['rp' => 'sc_races'], 'rp.race_name = r.parent_name',
				   ['parent_long_name' => 'long_name'], $select::JOIN_LEFT);
	}

/***************************************************************************************
	public function getRaceList($fetch=false)
	{
		$select = $this->getSelect()
			->order('long_name');

		return $fetch ? $this->fetchAll($select) : $select;		
	}

	public function getRaceListForFaction($factionId, $fetch=false)
	{
		$select = $this->getSelect()
			->where('r.faction = ?', $factionId)
			->order('long_name');

		return $fetch ? $this->fetchAll($select) : $select;		
	}

	public function getRaceListForPlayer($player_ident, $fetch=false)
	{
		$select = $this->getSelect()
			->join(array('pr' => 'sc_player_races'),
			      	     'pr.race_ident = r.race_ident',
			      	     array('xp', 'level'))
			->where('pr.player_ident = ?', $player_ident)
			->order('long_name');

		return $fetch ? $this->fetchAll($select) : $select;		
	}

	public function getRaceForIdent($ident)
	{
		$select = $this->getSelect()
			->where('r.race_ident = ?', $ident);

		return $this->fetchRow($select);
	}

	public function getRaceForName($name)
	{
		$select = $this->getSelect()
			->where('r.race_name like ?', '%' . $name . '%');

		return $this->fetchRow($select);
	}
	
	public function selectPlayerRaces($ident)
	{
		return $this->getSelect()
			    ->joinLeft(array('sc_player_races', 'pr'),
				       'r.player_ident == pr.player_ident',
				       array('pr.xp','pr.level'))
			    ->where('player_ident = ?', $ident)
			    ->order('long_name');
	}
 ***************************************************************************************/    
}