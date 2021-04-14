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
     * Return aliases for a player.
     *
     * @param  int $id Identifier of the player to return aliases for.
     * @return PlayerAlias[]
     */
    public function fetchAliasesForPlayer($id);

    /**
     * Return aliases for a player with the given name.
     *
     * @param  int $name name of the player to return aliases of.
     * @return PlayerAlias[]
     */
    public function fetchAliasesForName($name);

    /**
     * Return a set of all aliases that match players with $name (have $name in them).
     *
     * @param  int $name name of the race to match.
     * @param  bool $paginated true to return paginated results.
     * @return PlayerAlias[]
     */
	public function fetchAliasesMatchingName($name, $paginated = false);
}