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

use SourceCraft\Model\FactionRepositoryInterface;

class FactionDbSelect implements FactionRepositoryInterface
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
     * @var Faction
     */
    private $prototype;

    /**
     * @param AdapterInterface $db
     */
    public function __construct(AdapterInterface $db,
                                HydratorInterface $hydrator,
                                Faction $prototype)
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

    /**
     * {@inheritDoc}
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function findFaction($id)
    {
        $sql    = new Sql($this->db);
        $select = $this->getSelect($sql);
        $select->where(['f.faction = ?' => $id]);
    
        $statement = $sql->prepareStatementForSqlObject($select);
        $result    = $statement->execute();
    
        if (! $result instanceof ResultInterface || ! $result->isQueryResult()) {
            throw new RuntimeException(sprintf(
                'Failed retrieving faction with identifier "%s"; unknown database error.',
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

    private function getSelect($sql)
	{
        $select = $sql->select();
		return $select->from(['f' => 'sc_factions'])
            ->columns(['faction', 'long_name', 'image', 'description']);
	}


/****************************************************************************************
	protected $_use_adapter = "sc";
	protected $_name = 'sc_factions';
	protected $_primary = array("faction");
	protected $_cols = array(
		'faction'	=> 'faction',
		'long_name'	=> 'long_name',
		'description'	=> 'description',
		'image'		=> 'image',
		'add_date'	=> 'add_date'
	);	

	public function getFactionList($has_races=false,$fetch=false)
	{
		$select = $this->select()
			->from(array('f' => 'sc_factions'),
			       array('faction', 'long_name', 'image',
			       	     'description' => 'f.description'));

		if ($has_races)
		{
			$select->where('exists (select * from sc_races r where r.faction = f.faction)');
		}

		$select->order('long_name');

		return $fetch ? $this->fetchAll($select) : $select;		
	}

	public function getFactionListForPlayer($player_ident, $fetch=false)
	{
		$select = $this->select()
				->setIntegrityCheck(false)
				->from(array('f' => 'sc_factions'),
	                               array('faction', 'long_name', 'image',
			       	             'description' => 'f.description'))
				->joinLeft(array('pt' => 'sc_player_tech'),
				   		 'f.faction = pt.faction',
				           array('pt.tech_count','pt.tech_level'))
				->where('player_ident = ?', $player_ident)
				->order('long_name');

		return $fetch ? $this->fetchAll($select) : $select;		
	}

	public function getFaction($factionId)
	{
		$select = $this->select()
				->where('faction = ?', $factionId);
		return $this->fetchRow($select);
	}
*********************************************************************************************/
}