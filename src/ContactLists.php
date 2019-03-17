<?php
namespace T3ko\SplioData;

use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as A;

class ContactLists
{
    /**
     * @var ContactList[]|ArrayCollection
     * @A\Type("ArrayCollection<T3ko\SplioData\ContactList>")
     */
    private $lists;

    /**
     * @return ArrayCollection|ContactList[]
     */
    public function getLists()
    {
        return $this->lists;
    }

}