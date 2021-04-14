<?php
namespace SourceCraft\Model;

interface PlayerTechDbInterface
{
    /**
     * Return a set of all sourcecraft races that we can iterate over.
     *
     * Each entry should be a Player instance.
     *
     * @param  bool $paginated true to return paginated results.
     * @return Player[]
     */
    public function fetchAll($paginated = false);

    /**
     * Return tech levels for a player.
     *
     * @param  int $id Identifier of the player to return aliases for.
     * @return PlayerAlias[]
     */
    public function fetchTechForPlayer($id);
}