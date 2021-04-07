<?php
namespace SourceCraft\Model;

use InvalidArgumentException;
use RuntimeException;

use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\Adapter\Driver\ResultInterface;
use Laminas\Db\Sql\Sql;

//use Laminas\Db\ResultSet\ResultSet;
//use Laminas\Hydrator\ReflectionHydrator;
use Laminas\Hydrator\HydratorInterface;
use Laminas\Db\ResultSet\HydratingResultSet;

use SourceCraft\Model\RaceRepositoryInterface;

class RaceDbSqlRepository implements RaceRepositoryInterface
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
    private $racePrototype;

    /**
     * @param AdapterInterface $db
     */
    public function __construct(AdapterInterface $db,
                                HydratorInterface $hydrator,
                                Race $racePrototype)
    {
        $this->db            = $db;
        $this->hydrator      = $hydrator;
        $this->racePrototype = $racePrototype;
    }

    /**
     * {@inheritDoc}
     */
    public function fetchAll($paginated = false)
    {
        $sql    = new Sql($this->db);
        $select = $this->getRaceSelect($sql);

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
        
            $resultSet = new HydratingResultSet($this->hydrator, $this->racePrototype);
            $resultSet->initialize($result);
            return $resultSet;
        }
    }

    private function fetchPaginatedResults($sql, $select)
    {
        // Create a new pagination adapter object:
        $paginatorAdapter = new DbSelect(
            // our configured select object:
            $select,
            // the adapter to run it against:
            $db,
            // the result set to hydrate:
            $racePrototype
        );

        $paginator = new Paginator($paginatorAdapter);
        return $paginator;
    }

    /**
     * {@inheritDoc}
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function findRace($id)
    {
        $sql    = new Sql($this->db);
        $select = $this->getRaceSelect($sql);
        $select->where(['race_ident = ?' => $id]);
    
        $statement = $sql->prepareStatementForSqlObject($select);
        $result    = $statement->execute();
    
        if (! $result instanceof ResultInterface || ! $result->isQueryResult()) {
            throw new RuntimeException(sprintf(
                'Failed retrieving race with identifier "%s"; unknown database error.',
                $id
            ));
        }
    
        $resultSet = new HydratingResultSet($this->hydrator, $this->postPrototype);
        $resultSet->initialize($result);
        $post = $resultSet->current();
    
        if (! $post) {
            throw new InvalidArgumentException(sprintf(
                'Race with identifier "%s" not found.',
                $id
            ));
        }
    
        return $post;
    }

    private function getRaceSelect($sql)
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