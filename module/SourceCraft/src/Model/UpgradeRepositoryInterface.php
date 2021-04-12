<?php
namespace SourceCraft\Model;

interface UpgradeDbInterface
{
    /**
     * Return a set of all upgrades that belong to a race.
     *
     * @param  int $race_ident the race to get upgrades for.
     * @param  bool $paginated true to return paginated results.
     * @return Upgrade[]
     */
    public function fetchUpgradesForRace($race_ident, $paginated = false);
}