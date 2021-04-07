<?php
namespace SourceCraft\Model;

class RaceRepository implements RaceRepositoryInterface
{
    private $data = [
        1 => [
            'id'    => 1,
            'name' => 'race1',
            'longName' => 'Race #1',
            'parentName'  => '',
            'faction'  => '',
            'type'  => '',
            'description'  => '',
            'image'  => '',
            'requiredLevel'  => 0,
            'techLevel'  => 0,
            'addDate'  => '',
        ],
        2 => [
            'id'    => 2,
            'name' => 'race2',
            'longName' => 'Race #2',
            'parentName'  => '',
            'faction'  => '',
            'type'  => '',
            'description'  => '',
            'image'  => '',
            'requiredLevel'  => 0,
            'techLevel'  => 0,
            'addDate'  => '',
        ],
        3 => [
            'id'    => 3,
            'name' => 'race3',
            'longName' => 'Race #3',
            'parentName'  => '',
            'faction'  => '',
            'type'  => '',
            'description'  => '',
            'image'  => '',
            'requiredLevel'  => 0,
            'techLevel'  => 0,
            'addDate'  => '',
        ],
        4 => [
            'id'    => 4,
            'name' => 'race4',
            'longName' => 'Race #4',
            'parentName'  => '',
            'faction'  => '',
            'type'  => '',
            'description'  => '',
            'image'  => '',
            'requiredLevel'  => 0,
            'techLevel'  => 0,
            'addDate'  => '',
        ],
        5 => [
            'id'    => 5,
            'name' => 'race5',
            'longName' => 'Race #5',
            'parentName'  => '',
            'faction'  => '',
            'type'  => '',
            'description'  => '',
            'image'  => '',
            'requiredLevel'  => 0,
            'techLevel'  => 0,
            'addDate'  => '',
        ],
    ];

    /**
     * {@inheritDoc}
     */
    public function fetchAll()
    {
        return array_map(function ($race) {
            return new Race(
                $race['name'],
                $race['longName'],
                $race['parentName'],
                $race['faction'],
                $race['type'],
                $race['description'],
                $race['image'],
                $race['requiredLevel'],
                $race['techLevel'],
                $race['addDate'],
                $race['id']
            );
        }, $this->data);
    }

    /**
     * {@inheritDoc}
     */
    public function findRace($id)
    {
        if (! isset($this->data[$id])) {
            throw new DomainException(sprintf('Race by id "%s" not found', $id));
        }

        return new Race(
            $this->data[$id]['name'],
            $this->data[$id]['longName'],
            $this->data[$id]['parentName'],
            $this->data[$id]['faction'],
            $this->data[$id]['type'],
            $this->data[$id]['description'],
            $this->data[$id]['image'],
            $this->data[$id]['requiredLevel'],
            $this->data[$id]['techLevel'],
            $this->data[$id]['addDate'],
            $this->data[$id]['id']
        );
    }
}