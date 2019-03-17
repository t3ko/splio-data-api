<?php
namespace T3ko\SplioData;

use JMS\Serializer\Annotation as A;

class ContactList
{
    /**
     * @var int
     * @A\Type("int")
     */
    private $id;

    /**
     * @var string
     * @A\Type("string")
     */
    private $name;

    /**
     * @var int|null
     * @A\Type("int")
     */
    private $members;

    /**
     * ContactList constructor.
     * @param int $id
     * @param string $name
     * @param int|null $members
     */
    public function __construct($id, $name, $members = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->members = $members;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return int|null
     */
    public function getMembers()
    {
        return $this->members;
    }



}