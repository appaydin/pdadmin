<?php

/*
 * This file is part of the pdAdmin package.
 *
 * (c) pdAdmin <http://pdadmin.net/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AccountBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * User Table
 *
 * @ORM\Table(name="user")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

    /**
     * @var
     *
     * @ORM\OneToOne(targetEntity="Profile", inversedBy="userId", cascade={"persist", "merge", "remove"})
     * @ORM\JoinColumn(name="profile_id", referencedColumnName="id")
     */
    private $profile;

    /**
     * @ORM\ManyToMany(targetEntity="AccountBundle\Entity\Group")
     * @ORM\JoinTable(name="user_group_tax",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id", onDelete="CASCADE")})
     */
    protected $groups;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->createdAt = new \DateTime;
    }

    /**
     * Set Username to Email
     *
     * @param string $email
     * @return $this
     */
    public function setEmail($email)
    {
        $email = is_null($email) ? '' : $email;
        parent::setEmail($email);
        parent::setUsername($email);

        return $this;
    }

    /**
     * Return User Roles
     *
     * @return array
     */
    public function getRolesUser()
    {
        return $this->roles;
    }

    public function addRole($role)
    {
        $role = strtoupper($role);

        if (!in_array($role, $this->roles, true)) {
            $this->roles[] = $role;
        }

        return $this;
    }

    public function clearGroups()
    {
        $this->getGroups()->clear();

        return $this;
    }

    /**
     * Set profile
     *
     * @param \AccountBundle\Entity\Profile $profile
     *
     * @return User
     */
    public function setProfile(\AccountBundle\Entity\Profile $profile = null)
    {
        $this->profile = $profile;

        return $this;
    }

    /**
     * Get profile
     *
     * @return \AccountBundle\Entity\Profile
     */
    public function getProfile()
    {
        return $this->profile;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return User
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}
