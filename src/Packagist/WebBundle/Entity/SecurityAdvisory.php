<?php declare(strict_types=1);

namespace Packagist\WebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Packagist\WebBundle\SecurityAdvisory\RemoteSecurityAdvisory;

/**
 * @ORM\Entity(repositoryClass="Packagist\WebBundle\Entity\SecurityAdvisoryRepository")
 * @ORM\Table(
 *     name="security_advisory",
 *     uniqueConstraints={@ORM\UniqueConstraint(name="source_remoteid_idx", columns={"source","remoteId"})},
 *     indexes={
 *         @ORM\Index(name="package_name_idx",columns={"packageName"}),
 *         @ORM\Index(name="updated_at_idx",columns={"updatedAt"})
 *     }
 * )
 */
class SecurityAdvisory
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $remoteId;

    /**
     * @ORM\Column(type="string")
     */
    private $packageName;

    /**
     * @ORM\Column(type="string")
     */
    private $title;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $link;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $cve;

    /**
     * @ORM\Column(type="string")
     */
    private $affectedVersions;

    /**
     * @ORM\Column(type="string")
     */
    private $source;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    public function __construct(RemoteSecurityAdvisory $advisory, string $source)
    {
        $this->source = $source;
        $this->updateAdvisory($advisory);
    }

    public function updateAdvisory(RemoteSecurityAdvisory $advisory): void
    {
        if (
            $this->remoteId !== $advisory->getId() ||
            $this->packageName !== $advisory->getPackageName() ||
            $this->title !== $advisory->getTitle() ||
            $this->link !== $advisory->getLink() ||
            $this->cve !== $advisory->getCve() ||
            $this->affectedVersions !== $advisory->getAffectedVersions()
        ) {
            $this->updatedAt = new \DateTime();
        }

        $this->remoteId = $advisory->getId();
        $this->packageName = $advisory->getPackageName();
        $this->title = $advisory->getTitle();
        $this->link = $advisory->getLink();
        $this->cve = $advisory->getCve();
        $this->affectedVersions = $advisory->getAffectedVersions();
    }

    public function getRemoteId(): string
    {
        return $this->remoteId;
    }

    public function getPackageName(): string
    {
        return $this->packageName;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function getCve(): ?string
    {
        return $this->cve;
    }

    public function getAffectedVersions(): string
    {
        return $this->affectedVersions;
    }

    public function getSource(): string
    {
        return $this->source;
    }
}