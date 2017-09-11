<?php

namespace DataBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MDB;

/**
 * @MDB\Document{
 *     db = "prod",
 *     collection = "game"
 * }
 */
class Game
{
    /**
     * @MDB\Id
     */
    protected $id;

    /**
     * @MDB\Field(type="string")
     */
    protected $date;

    /**
     * @MDB\Field(type="string")
     */
    protected $player;

    /**
     * @MDB\Field(type="string")
     */
    protected $npc;

    /**
     * @MDB\Field(type="string")
     */
    protected $result;

    /**
     * @MDB\ReferenceOne(targetDocument="User")
     */
    protected $user;

    /**
     * Set id
     */
    public function setId($id)
    {
	$this->id = $id;
	return $this;
    }

    /**
     * Get $id
     */
    public function getId()
    {
	return $this->id;
    }

    /**
     * Set $date
     */
    public function setDate()
    {
	$date = new \DateTime();
	$this->date = $date->format('Y-m-d H:i:s');
	return $this;
    }

    /**
     * Get $date
     */
    public function getDate()
    {
	return $this->date;
    }

    /**
     * Set $player
     */
    public function setPlayer($player)
    {
	$this->player = $player;
        return $this;
    }

    /**
     * Get $player
}    */
    public function getPlayer()
    {
	return $this->player;
    }

    /**
     * Set $npc
     */
    public function setNpc($npc)
    {
	$this->npc = $npc;
        return $this;
    }

    /**
     * Get $npc
     */
    public function getNpc()
    {
	return $this->npc;
    }

    /**
     * Set $result
     */
    public function setResult($result)
    {
	$this->result = $result;
	return $this;
    }

    /**
     * Get $result
     */
    public function getResult()
    {
	return $this->result;
    }

    /**
     * Set $user
     */
    public function setUser(\DataBundle\Document\User $user)
    {
	$this->user = $user;
	return $this;
    }

    /**
     * Get $user
     */
    public function getUser()
    {
	return $this->user;
    }
}
