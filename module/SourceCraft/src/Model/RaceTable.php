<?php
namespace SourceCraft\Model;

use RuntimeException;

use Laminas\Db\Sql\Select;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\TableGateway\TableGatewayInterface;

use Laminas\Paginator\Adapter\DbSelect;
use Laminas\Paginator\Paginator;

class RaceTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll($paginated = false)
    {
        if ($paginated) {
            return $this->fetchPaginatedResults();
        }

        return $this->tableGateway->select();
    }

    private function fetchPaginatedResults()
    {
        // Create a new Select object for the table:
        $select = new Select($this->tableGateway->getTable());

        // Create a new result set based on the Race entity:
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Race());

        // Create a new pagination adapter object:
        $paginatorAdapter = new DbSelect(
            // our configured select object:
            $select,
            // the adapter to run it against:
            $this->tableGateway->getAdapter(),
            // the result set to hydrate:
            $resultSetPrototype
        );

        $paginator = new Paginator($paginatorAdapter);
        return $paginator;
    }

    public function getRace($race_ident)
    {
        $race_ident = (int) $race_ident;
        $rowset = $this->tableGateway->select(['race_ident' => $race_ident]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $race_ident
            ));
        }

        return $row;
    }

    public function saveRace(Race $Race)
    {
        $data = $Race->getArrayCopy();

        $race_ident = (int) $Race->race_ident;

        if ($race_ident === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        try {
            $this->getRace($race_ident);
        } catch (RuntimeException $e) {
            throw new RuntimeException(sprintf(
                'Cannot update Race with identifier %d; does not exist',
                $race_ident
            ));
        }

        $this->tableGateway->update($data, ['race_ident' => $race_ident]);
    }

    public function deleteRace($race_ident)
    {
        $this->tableGateway->delete(['race_ident' => (int) $race_ident]);
    }
}