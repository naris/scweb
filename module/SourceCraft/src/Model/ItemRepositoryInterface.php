<?php
namespace SourceCraft\Model;

interface ItemRepositoryInterface
{
    /**
     * Return a set of all sourcecraft items that we can iterate over.
     *
     * Each entry should be a Item instance.
     *
     * @param  bool $paginated true to return paginated results.
     * @return Item[]
     */
    public function fetchAll($paginated = false);

    /**
     * Return a single item.
     *
     * @param  int $id Identifier of the item to return.
     * @return Item
     */
    public function findItem($id);

    /**
     * Return a single item by name.
     *
     * @param  int $name name of the item to return.
     * @return Item
     */
    public function findItembyName($name);

    /**
     * Return a set of all items that match $name (have $name in them).
     *
     * @param  int $name name of the item to match.
     * @param  bool $paginated true to return paginated results.
     * @return Item
     */
	public function findMatchingItems($name, $paginated = false);
}