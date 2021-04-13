<?php
namespace SourceCraft\Model;

interface PlayerAliasDbInterface
{
    /**
     * Return a set of all aliases that we can iterate over.
     *
     * Each entry should be a Player instance.
     *
     * @param  bool $paginated true to return paginated results.
     * @return PlayerAlias[]
     */
    public function fetchAll($paginated = false);

    /**
     * Return a single race.
     *
     * @param  int $id Identifier of the player to return aliases for.
     * @return PlayerAlias[]
     */
    public function fetchAliasesForPlayer($id);

    /**
     * Return a single race by name.
     *
     * @param  int $name name of the player to return aliases of.
     * @return PlayerAlias[]
     */
    public function fetchAliasesForName($name);

    /**
     * Return a set of all aliases that match $name (have $name in them).
     *
     * @param  int $name name of the race to match.
     * @param  bool $paginated true to return paginated results.
     * @return PlayerAlias[]
     */
	public function fetchAliasesMatchingName($name, $paginated = false);
}