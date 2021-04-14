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

use SourceCraft\Model\PlayerAliasDbInterface;

class PlayerAliasDbSelect implements PlayerAliasDbInterface
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
                                PlayerAlias $prototype)
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
    public function fetchAliasesForPlayer($id)
    {
        $sql    = new Sql($this->db);
        $select = $this->getSelect($sql);
        $select->where(["pa.player_ident = ?" => $id]);

        //print "<br>id=".$id.", sql=".$select->getSqlString()."<br>";
        return $this->fetchSelect($sql, $select, $paginated);
    }

    /**
     * {@inheritDoc}
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function fetchAliasesForName($name)
    {
        $sql    = new Sql($this->db);
        $select = $this->getSelect($sql);
        $select->where(['p.name = ?' => $name]);
    
        $statement = $sql->prepareStatementForSqlObject($select);
        $result    = $statement->execute();
    
        return $this->fetchSelect($sql, $select, $paginated);
    }

	public function fetchAliasesMatchingName($name, $paginated = false)
	{
        $sql    = new Sql($this->db);
        $select = $this->getSelect($sql);
		$select->where(function (Where $where) {
                    $where->like('p.name', '%'.$name.'%');
               })
               ->order('name');

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
		return $select->from(['pa' => 'sc_player_alias'])
            ->columns(['player_ident', 'steamid', 'name',
                       'last_used']);
	}

/***************************************************************************************
	public function getAliasesForPlayer($player_ident)
	{
		return $this->fetchAll($this->getAliasSelect()
					->where('player_ident = ?', $player_ident)
					->order(array('last_used','name')));
	}

	public function getAliasesForSteamid($steamid)
	{
		return $this->fetchAll($this->getAliasSelect()
					->where('steamid = ?', $steamid)
					->order(array('last_used','name')));
	}

	public function getAliasesForName($name)
	{
		return $this->fetchAll($this->getAliasSelect()
					->where('name = ?', $name)
					->order(array('last_used','name')));
	}

	public function getAliasesMatchingName($name)
	{
		return $this->fetchAll($this->getAliasSelect()
					->where('name like ?', $name)->order('name')
					->order(array('last_used','name')));
	}

	private function getAliasSelect()
	{
		return $this->select()
			->from(array('pa' => 'sc_player_alias'),
				array('steamid', 'name', 'last_used',
			      		'last_used_date' => "DATE_FORMAT(last_used, '%m/%d/%y')"));
	}
 ***************************************************************************************/    
}