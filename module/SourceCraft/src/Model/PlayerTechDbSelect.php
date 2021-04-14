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

use SourceCraft\Model\PlayerTechDbInterface;

class PlayerTechDbSelect implements PlayerTechDbInterface
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
     * @var Player
     */
    private $prototype;

    /**
     * @param AdapterInterface $db
     */
    public function __construct(AdapterInterface $db,
                                HydratorInterface $hydrator,
                                PlayerTech $prototype)
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
    public function fetchTechForPlayer($id)
    {
        $sql    = new Sql($this->db);
        $select = $this->getSelect($sql);
        $select->where(["pt.player_ident = ?" => $id]);

        //print "<br>id=".$id.", sql=".$select->getSqlString()."<br>";
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
		return $select->from(['pt' => 'sc_player_tech'])
            ->columns(['player_ident', 'faction', 'tech_count', 'tech_level'])
			->join(['f' => 'sc_factions'], 'f.faction = pt.faction',
				   ['long_name', 'image'], $select::JOIN_LEFT);
	}

/***************************************************************************************
	public function getPlayerList($fetch=false)
	{
		$select = $this->getPlayerSelect();

		return $fetch ? $this->fetchAll($select) : $select;		
	}

	public function getPlayerForIdent($ident)
	{
		$select = $this->getPlayerSelect()
			->where('player_ident = ?', $ident);

		return $this->fetchRow($select);
	}

	public function getPlayerForSteamid($steamid)
	{
		$select = $this->getPlayerSelect()
			->where('steamid = ?', $steamid);

		return $this->fetchRow($select);
	}

	public function getPlayerForUsername($username)
	{
		$select = $this->getPlayerSelect()
			->where('username = ?', $username);

		return $this->fetchRow($select);
	}

	public function getPlayerForName($name)
	{
		$select = $this->getPlayerSelect()
			->where('name like ?', '%' . $name . '%');

		return $this->fetchAll($select);
	}

	private function getPlayerSelect()
	{
		return $this->select()
			->from(array('p' => 'sc_players'),
				array('player_ident', 'steamid', 'overall_level',
			       		'name', 'crystals', 'vespene', 'last_update',
			      		'last_update_date' => "DATE_FORMAT(last_update, '%m/%d/%y')"));
	}

	public function getPlayerListMatchingName($name, $fetch=false)
	{
		$select_players = $this->select()
					->setIntegrityCheck(false)
					->from(array('p' => 'sc_players'),
						array('player_ident', 'steamid', 'overall_level',
					       		'crystals', 'vespene', 'name'))
					->where('name like ?', '%' . $name . '%');

		$select_aliases = $this->select()
					->setIntegrityCheck(false)
					->from(array('p' => 'sc_players'),
						array('player_ident', 'steamid', 'overall_level',
					       		'crystals', 'vespene'))
					->join(array('pa' => 'sc_player_alias'),
				      			"pa.player_ident = p.player_ident",
				      			"name")
					->where('pa.name like ?', '%' . $name . '%');

		$select_union = $this->select()
					->setIntegrityCheck(false)
					->union(array($select_players, $select_aliases))
					->order('name');

		return $fetch ? $this->fetchAll($select_union) : $select_union;		
	}
 ***************************************************************************************/    
}