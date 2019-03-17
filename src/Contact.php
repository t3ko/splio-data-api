<?php
namespace T3ko\SplioData;

use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as A;

class Contact
{
    /**
     * @var string
     * @A\Type("string")
     */
    private $email;

    /**
     * @var \DateTime
     * @A\Type("DateTime<'Y-m-d H:i:s'>")
     */
    private $date;

    /**
     * @var string
     * @A\Type("string")
     * @A\SerializedName("firstname")
     */
    private $firstName;

    /**
     * @var string
     * @A\Type("string")
     * @A\SerializedName("lastname")
     */
    private $lastName;

    /**
     * @var string
     * @A\Type("string")
     */
    private $lang;

    /**
     * @var string
     * @A\Type("string")
     */
    private $cellphone;

    /**
     * @var Field[]|ArrayCollection
     * @A\Type("ArrayCollection<T3ko\SplioData\Field>")
     */
    private $fields;

    /**
     * @var ContactList[]|ArrayCollection
     * @A\Type("ArrayCollection<T3ko\SplioData\ContactList>")
     */
    private $lists;

    /**
     * Contact constructor.
     * @param string $email
     * @param \DateTime $date
     * @param string $firstName
     * @param string $lastName
     * @param string $lang
     * @param string $cellphone
     * @param Field[] $fields
     * @param ContactList[] $lists
     */
    public function __construct($email, \DateTime $date, $firstName, $lastName, $lang, $cellphone, array $fields, array $lists)
    {
        $this->email = $email;
        $this->date = $date;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->lang = $lang;
        $this->cellphone = $cellphone;
        $this->fields = new ArrayCollection($fields);
        $this->lists = new ArrayCollection($lists);
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getLang()
    {
        return $this->lang;
    }

    /**
     * @return string
     */
    public function getCellphone()
    {
        return $this->cellphone;
    }

    /**
     * @return Field[]
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @return ContactList[]
     */
    public function getLists()
    {
        return $this->lists;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @param string $lang
     */
    public function setLang($lang)
    {
        $this->lang = $lang;
    }

    /**
     * @param string $cellphone
     */
    public function setCellphone($cellphone)
    {
        $this->cellphone = $cellphone;
    }

    /**
     * @param ArrayCollection|Field[] $fields
     */
    public function setFields($fields)
    {
        $this->fields = $fields;
    }

    /**
     * @param Field $field
     */
    public function addField(Field $field)
    {
        $this->fields->add($field);
    }

    /**
     * @param ArrayCollection|ContactList[] $lists
     */
    public function setLists($lists)
    {
        $this->lists = $lists;
    }

    /**
     * @param ContactList $list
     */
    public function addList(ContactList $list)
    {
        $this->lists->add($list);
    }


}