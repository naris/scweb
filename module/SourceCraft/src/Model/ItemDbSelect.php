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

use SourceCraft\Model\ItemRepositoryInterface;

class ItemDbSelect implements ItemRepositoryInterface
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
     * @var ItemRace
     */
    private $prototype;

    /**
     * @param AdapterInterface $db
     */
    public function __construct(AdapterInterface $db,
                                HydratorInterface $hydrator,
                                Item $prototype)
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
    public function findItem($id)
    {
        $sql    = new Sql($this->db);
        $select = $this->getSelect($sql);
        $select->where(['i.item_ident = ?' => $id]);
    
        $statement = $sql->prepareStatementForSqlObject($select);
        $result    = $statement->execute();
    
        if (! $result instanceof ResultInterface || ! $result->isQueryResult()) {
            throw new RuntimeException(sprintf(
                'Failed retrieving item with identifier "%s"; unknown database error.',
                $id
            ));
        }
    
        $resultSet = new HydratingResultSet($this->hydrator, $this->prototype);
        $resultSet->initialize($result);
        $result = $resultSet->current();
    
        if (! $result) {
            throw new InvalidArgumentException(sprintf(
                'Item with identifier "%s" not found.',
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
    public function findItembyName($name)
    {
        $sql    = new Sql($this->db);
        $select = $this->getSelect($sql);
        $select->where(['i.item_name = ?' => $name]);
    
        $statement = $sql->prepareStatementForSqlObject($select);
        $result    = $statement->execute();
    
        if (! $result instanceof ResultInterface || ! $result->isQueryResult()) {
            throw new RuntimeException(sprintf(
                'Failed retrieving item with name "%s"; unknown database error.',
                $name
            ));
        }
    
        $resultSet = new HydratingResultSet($this->hydrator, $this->prototype);
        $resultSet->initialize($result);
        $result = $resultSet->current();
    
        if (! $result) {
            throw new InvalidArgumentException(sprintf(
                'Item with name "%s" not found.',
                $name
            ));
        }
    
        return $result;
    }

	public function findMatchingItems($name, $paginated = false)
	{
        $sql    = new Sql($this->db);
        $select = $this->getSelect($sql);
		$select->where(function (Where $where) {
                    $where->like('i.item_name', '%'.$name.'%');
               })
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
		return $select->from(['i' => 'sc_items'])
            ->columns(['item_ident', 'item_name', 'long_name', 'category',
                       'description', 'crystals', 'max', 'required_level',
                       'image', 'add_date']);
	}

	/***************************************************************************************
	protected $_use_adapter = "sc";
	protected $_name = 'sc_items';
	protected $_primary = array("item_ident");
	protected $_cols = array(
		'item_ident'    	=> 'item_ident',
		'item_name'  		=> 'item_name',
		'long_name'  		=> 'long_name',
		'category'  		=> 'category',
		'description'  		=> 'description',
		'crystals'  		=> 'crystals',
		'vespene'  		=> 'vespene',
		'max'  			=> 'max',
		'required_level'  	=> 'required_level',
		'image'  		=> 'image',
		'add_date'		=> 'add_date'
	);

	public function getItemList($fetch=false)
	{
		$select = $this->select()
			->order('long_name');

		return $fetch ? $this->fetchAll($select) : $select;		
	}

	public function getCategoryList($fetch=false)
	{
		$select = $this->select()
			->distinct()
			->from(array("i" => "sc_items"), "category")
			->order('category');

		return $fetch ? $this->fetchAll($select) : $select;		
	}

	public function getItemListForCategory($category, $fetch=false)
	{
		$select = $this->select()
			->where('category = ?', $category)
			->order('long_name');

		return $fetch ? $this->fetchAll($select) : $select;		
	}

	public function getItemListForName($name, $fetch=false)
	{
		$select = $this->select()
			->where('item_name like ?', '%' . $name . '%')
			->order('long_name');

		return $fetch ? $this->fetchAll($select) : $select;		
	}

	public function getItemForIdent($ident)
	{
		$select = $this->select()
			->where('item_ident = ?', $ident);

		return $this->fetchRow($select);
	}

	public function getItemForName($name)
	{
		$select = $this->select()
			->where('item_name like ?', '%' . $name . '%');

		return $this->fetchRow($select);
	}
 ***************************************************************************************/
}