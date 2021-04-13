<?php
namespace SourceCraft\Model;

interface PlayerDbInterface
{
    /**
     * Return a set of all sourcecraft players that we can iterate over.
     *
     * Each entry should be a Player instance.
     *
     * @param  bool $paginated true to return paginated results.
     * @return Player[]
     */
    public function fetchAll($paginated = false);

    /**
     * Return a single race.
     *
     * @param  int $id Identifier of the player to return.
     * @return Player
     */
    public function findPlayer($id);

    /**
     * Return a single race by name.
     *
     * @param  int $name name of the player to return.
     * @return Player
     */
    public function findPlayerbyName($name);

    /**
     * Return a set of all players that match $name (have $name in them).
     *
     * @param  int $name name of the race to match.
     * @param  bool $paginated true to return paginated results.
     * @return Player
     */
	public function findMatchingPlayers($name, $paginated = false);
}