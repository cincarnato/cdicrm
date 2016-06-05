<?php

namespace CdiCrm\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Zend\Form\Annotation;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="cdi_quick_contact")
 */
class QuickContact extends \CdiCommons\Entity\ExtendedEntity
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Annotation\Type("Zend\Form\Element\Hidden")
     */
    public $id = null;

    /**
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"asunto", "description":""})
     * @ORM\Column(type="string", length=150, unique=false, nullable=false,
     * name="subject")
     */
    public $subject = null;

    /**
     * @Annotation\Attributes({"type":"textarea"})
     * @Annotation\Options({"label":"descripcion", "description":""})
     * @ORM\Column(type="text", unique=false, nullable=false, name="description")
     */
    public $description = null;

    /**
     * @Annotation\Attributes({"type":"textarea"})
     * @Annotation\Options({"label":"Respuesta", "description":""})
     * @ORM\Column(type="text", unique=false, nullable=true, name="response")
     */
    public $response = null;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function __toString()
    {
        return (string) $this->subject;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function setResponse($response)
    {
        $this->response = $response;
    }


}

