<?php

namespace DataBundle\Document;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MDB;

/**
 * @MDB\Document
 */
class User extends BaseUser
{
    /**
     * @MDB\Id(strategy="auto")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }
}
