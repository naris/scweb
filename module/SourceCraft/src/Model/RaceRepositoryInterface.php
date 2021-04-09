<?php
namespace SourceCraft\Model;

interface RaceRepositoryInterface
{
    /**
     * Return a set of all sourcecraft races that we can iterate over.
     *
     * Each entry should be a Race instance.
     *
     * @param  bool $paginated true to return paginated results.
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

    /**
     * Return a single race by name.
     *
     * @param  int $name name of the race to return.
     * @return Race
     */
    public function findRacebyName($name);

    /**
     * Return a set of all races that match $name (have $name in them).
     *
     * @param  int $name name of the race to match.
     * @param  bool $paginated true to return paginated results.
     * @return Race
     */
	public function findMatchingRaces($name, $paginated = false);

    /**
     * Return a set of all races that belong to a faction.
     *
     * @param  int $factionId the faction to get races for.
     * @param  bool $paginated true to return paginated results.
     * @return Race
     */
    public function fetchRacesForFaction($factionId, $paginated = false);
}