<?php
namespace SourceCraft\Model;

interface RaceRepositoryInterface
{
    /**
     * Return a set of all sourcecraft races that we can iterate over.
     *
     * Each entry should be a Race instance.
     *
     * @return Race[]
     */
    public function fetchAll($paginated = false);

    /**
     * Return a single race.
     *
     * @param  int $id Identifier of the race to return.
     * @return Race
     */
    public function findRace($id);
}