<?php

namespace TomJerryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GalaryImages
 *
 * @ORM\Table(name="galary_images")
 * @ORM\Entity(repositoryClass="TomJerryBundle\Repository\GalaryImagesRepository")
 */
class GalaryImages
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="guId", type="string", length=32)
     */
    private $guId;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=70)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="size", type="integer")
     */
    private $size;

    /**
     * @var string
     *
     * @ORM\Column(name="imgType", type="string", length=30)
     */
    private $imgType;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="uploadedDate", type="datetime")
     */
    private $uploadedDate;

    /**
     * @var string
     *
     * @ORM\Column(name="imgBlob", type="blob")
     */
    private $imgBlob;
    
    /**
     * @var string
     *
     * @ORM\Column(name="imgDisplayName", type="string", length=40, nullable=true)
     */
    private $imgDisplayName;

    /**
     * @var int
     *
     * @ORM\Column(name="imgHeight", type="integer", nullable=true)
     */
    private $imgHeight;

    /**
     * @var int
     *
     * @ORM\Column(name="imgWidth", type="integer", nullable=true)
     */
    private $imgWidth;

    /**
     * @ORM\ManyToOne(targetEntity="AkjnBundle\Entity\User")
     * @ORM\JoinColumn(name="uploaded_by", referencedColumnName="id")
     */
    private $uploadedBy;

    /**
     * @var bool
     *
     * @ORM\Column(name="enableDissable", type="boolean")
     */
    private $enableDissable;
    
    public function __construct() {
        $this->guId = md5(uniqid(php_uname('n')));
        $this->uploadedDate = new \DateTime("now");
    }



    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set guId
     *
     * @param string $guId
     *
     * @return GalaryImages
     */
    public function setGuId($guId)
    {
        $this->guId = $guId;

        return $this;
    }

    /**
     * Get guId
     *
     * @return string
     */
    public function getGuId()
    {
        return $this->guId;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return GalaryImages
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set size
     *
     * @param integer $size
     *
     * @return GalaryImages
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return integer
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set imgType
     *
     * @param string $imgType
     *
     * @return GalaryImages
     */
    public function setImgType($imgType)
    {
        $this->imgType = $imgType;

        return $this;
    }

    /**
     * Get imgType
     *
     * @return string
     */
    public function getImgType()
    {
        return $this->imgType;
    }

    /**
     * Set uploadedDate
     *
     * @param \DateTime $uploadedDate
     *
     * @return GalaryImages
     */
    public function setUploadedDate($uploadedDate)
    {
        $this->uploadedDate = $uploadedDate;

        return $this;
    }

    /**
     * Get uploadedDate
     *
     * @return \DateTime
     */
    public function getUploadedDate()
    {
        return $this->uploadedDate;
    }

    /**
     * Set imgBlob
     *
     * @param string $imgBlob
     *
     * @return GalaryImages
     */
    public function setImgBlob($imgBlob)
    {
        $this->imgBlob = $imgBlob;

        return $this;
    }

    /**
     * Get imgBlob
     *
     * @return string
     */
    public function getImgBlob()
    {
        return $this->imgBlob;
    }

    /**
     * Set imgHeight
     *
     * @param integer $imgHeight
     *
     * @return GalaryImages
     */
    public function setImgHeight($imgHeight)
    {
        $this->imgHeight = $imgHeight;

        return $this;
    }

    /**
     * Get imgHeight
     *
     * @return integer
     */
    public function getImgHeight()
    {
        return $this->imgHeight;
    }

    /**
     * Set imgWidth
     *
     * @param integer $imgWidth
     *
     * @return GalaryImages
     */
    public function setImgWidth($imgWidth)
    {
        $this->imgWidth = $imgWidth;

        return $this;
    }

    /**
     * Get imgWidth
     *
     * @return integer
     */
    public function getImgWidth()
    {
        return $this->imgWidth;
    }

    /**
     * Set enableDissable
     *
     * @param boolean $enableDissable
     *
     * @return GalaryImages
     */
    public function setEnableDissable($enableDissable)
    {
        $this->enableDissable = $enableDissable;

        return $this;
    }

    /**
     * Get enableDissable
     *
     * @return boolean
     */
    public function getEnableDissable()
    {
        return $this->enableDissable;
    }

    /**
     * Set uploadedBy
     *
     * @param \AkjnBundle\Entity\User $uploadedBy
     *
     * @return GalaryImages
     */
    public function setUploadedBy(\AkjnBundle\Entity\User $uploadedBy = null)
    {
        $this->uploadedBy = $uploadedBy;

        return $this;
    }

    /**
     * Get uploadedBy
     *
     * @return \AkjnBundle\Entity\User
     */
    public function getUploadedBy()
    {
        return $this->uploadedBy;
    }

    /**
     * Set imgDisplayName
     *
     * @param string $imgDisplayName
     *
     * @return GalaryImages
     */
    public function setImgDisplayName($imgDisplayName)
    {
        $this->imgDisplayName = $imgDisplayName;

        return $this;
    }

    /**
     * Get imgDisplayName
     *
     * @return string
     */
    public function getImgDisplayName()
    {
        return $this->imgDisplayName;
    }
}
