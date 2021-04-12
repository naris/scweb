<?php
namespace SourceCraft\Model;

interface UpgradeDbInterface
{
    /**
     * Return a set of all upgrades that belong to a race.
     *
     * @param  int $raceId the race to get upgrades for.
     * @param  bool $paginated true to return paginated results.
     * @return Upgrade[]
     */
    public function fetchUpgradesForRace($raceId, $paginated = false);

    /**
     * Return a set of all upgrades that belong to a player.
     *
     * @param  int $playerId the race to get upgrades for.
     * @param  bool $paginated true to return paginated results.
     * @return Upgrade[]
     */
	public function fetchUpgradesForPlayer($playerId, $paginated=false);
}