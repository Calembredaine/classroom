<?php

namespace OC\PlatformBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Config\Definition\Exception\Exception;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Table(name="oc_advert")
 * @ORM\Entity(repositoryClass="OC\PlatformBundle\Repository\AdvertRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Advert
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
   * @var \DateTime
   *
   * @ORM\Column(name="date", type="datetime")
   */
  private $date;

  /**
   * @var string
   *
   * @ORM\Column(name="title", type="string", length=255)
   */
  private $title;

  /**
   * @var string
   *
   * @ORM\Column(name="author", type="string", length=255)
   */
  private $author;

  /**
   * @var string
   *
   * @ORM\Column(name="content", type="string", length=255)
   */
  private $content;

  /**
   * @var string
   *
   * @ORM\Column(name="email", type="string", length=255)
   */
  private $email;
  
  /**
   * @ORM\Column(name="published", type="boolean")
   */
  private $published = true;
  /**
   * @ORM\Column(name="nb_applications", type="integer")
   */
  private $nbApplications = 0;
  /**
   * @ORM\Column(name="updated_at", type="datetime", nullable=true)
   */
  private $updatedAt;
  
  /**
   * @Gedmo\Slug(fields={"title"})
   * @ORM\Column(name="slug", type="string", length=255, unique=true)
   */
  private $slug;
  /**
   * @ORM\OneToOne(targetEntity="OC\PlatformBundle\Entity\Image", cascade={"persist"})
   */
  
  private $image;

  /**
   * @ORM\ManyToMany(targetEntity="OC\PlatformBundle\Entity\Category", cascade={"persist"})
   * @ORM\JoinTable(name="oc_advert_category")
   */
  private $categories;

  /**
   * @ORM\OneToMany(targetEntity="OC\PlatformBundle\Entity\Application", mappedBy="advert")
   */
  private $applications; // Notez le « s », une annonce est liée à plusieurs candidatures

  public function __construct()
  {
    $this->date         = new \Datetime();
    $this->updatedAt    = new \Datetime();
    $this->categories   = new ArrayCollection();
    $this->applications = new ArrayCollection();
  }

  /**
   * @return int
   */
  public function getId()
  {
    return $this->id;
  }

  /**
   * @return \DateTime
   */
  public function getUpdatedAt()
  {
      return $this->updatedAt;
  }
  /**
   * @param \DateTime $date
   */
  public function setUpdatedAt($date)
  {
      $this->updatedAt = $date;
  }
  
  /**
   * @ORM\PreUpdate
   */
  public function updateDate()
  {
      $this->setUpdatedAt(new \Datetime());
  }
  
  /**
   * @param \DateTime $date
   */
  public function setDate($date)
  {
      $this->date = $date;
  }
  
  /**
   * @return \DateTime
   */
  public function getDate()
  {
      return $this->date;
  }
  /**
   * @param string $title
   */
  public function setTitle($title)
  {
    $this->title = $title;
  }

  /**
   * @return string
   */
  public function getTitle()
  {
    return $this->title;
  }

  /**
   * @param string $author
   */
  public function setAuthor($author)
  {
    $this->author = $author;
  }

  /**
   * @return string
   */
  public function getAuthor()
  {
    return $this->author;
  }

  /**
   * @param string $content
   */
  public function setContent($content)
  {
    $this->content = $content;
  }

  /**
   * @return string
   */
  public function getContent()
  {
    return $this->content;
  }

  /**
   * @param string $email
   */
  public function setEmail($email)
  {
      if (!preg_match ( " /^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/ " , $email ) )
      {
          throw new Exception("This is not a valid email address");
      }
    $this->email = $email;
  }

  /**
   * @return string
   */
  public function getEmail()
  {
    return $this->email;
  }
  
  /**
   * @param integer $nbApplications
   */
  public function setNbApplications($nbApplications)
  {
      $this->nbApplications = $nbApplications;
  }
  
  /**
   * @return integer
   */
  public function getNbApplications()
  {
      return $this->nbApplications;
  }
  
  public function increaseApplication()
  {
      $this->nbApplications++;
  }
  
  public function decreaseApplication()
  {
      $this->nbApplications--;
  }
  /**
   * @param bool $published
   */
  public function setPublished($published)
  {
      $this->published = $published;
  }
  
  /**
   * @return bool
   */
  public function getPublished()
  {
      return $this->published;
  }
  
  public function setImage(Image $image = null)
  {
    $this->image = $image;
  }

  public function getImage()
  {
    return $this->image;
  }

  /**
   * @param Category $category
   */
  public function addCategory(Category $category)
  {
    $this->categories[] = $category;
  }

  /**
   * @param Category $category
   */
  public function removeCategory(Category $category)
  {
    $this->categories->removeElement($category);
  }

  /**
   * @return ArrayCollection
   */
  public function getCategories()
  {
    return $this->categories;
  }

  /**
   * @param Application $application
   */
  public function addApplication(Application $application)
  {
    $this->applications[] = $application;

    // On lie l'annonce à la candidature
    $application->setAdvert($this);
  }

  /**
   * @param Application $application
   */
  public function removeApplication(Application $application)
  {
    $this->applications->removeElement($application);
  }

  /**
   * @return \Doctrine\Common\Collections\Collection
   */
  public function getApplications()
  {
    return $this->applications;
  }
}