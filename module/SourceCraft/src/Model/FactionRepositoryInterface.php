<?php
namespace SourceCraft\Model;

interface FactionDbInterface
{
    /**
     * Return a set of all sourcecraft races that we can iterate over.
     *
     * Each entry should be a Race instance.
     *
     * @return Faction[]
     */
    public function fetchAll($paginated = false);

    /**
     * Return a single faction.
     *
     * @param  int $id Identifier of the race to return.
     * @return Faction
     */
    public function findFaction($id);
}