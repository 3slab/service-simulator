<?php

namespace App\Entity;

use App\Repository\RequestRepository;
use Ramsey\Uuid\UuidInterface;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Blameable\Traits\BlameableEntity;


/**
 * @ORM\Entity(repositoryClass=RequestRepository::class)
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
 */
class Request
{
    /*
     * Hook blameable behavior
     * updates createdBy, updatedBy fields
     */
    use BlameableEntity;

    /*
    * Hook timestampable behavior
    * updates createdAt, updatedAt fields
    */
    use TimestampableEntity;

    /*
     * Hook SoftDeleteable behavior
     * updates deletedAt field
     */
    use SoftDeleteableEntity;

    /**
     * @var UuidInterface
     *
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class=UuidGenerator::class)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $httpVerb;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $regex;

    /**
     * @ORM\Column(type="datetime")
     */
    private $callAt;

    /**
     * @ORM\Column(type="json")
     */
    private $headerRequest = [];

    /**
     * @ORM\Column(type="text")
     */
    private $bodyRequest;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $headerResponse = [];

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $bodyResponse;

    /**
     * @return Ramsey\Uuid\UuidInterface
     */
    public function getId(): UuidInterface
    {
        return $this->id;
    }


    public function getHttpVerb(): ?string
    {
        return $this->httpVerb;
    }

    public function setHttpVerb(string $httpVerb): self
    {
        $this->httpVerb = $httpVerb;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getRegex(): ?string
    {
        return $this->regex;
    }

    public function setRegex(string $regex): self
    {
        $this->regex = $regex;

        return $this;
    }

    public function getCallAt(): ?\DateTimeInterface
    {
        return $this->callAt;
    }

    public function setCallAt(\DateTimeInterface $callAt): self
    {
        $this->callAt = $callAt;

        return $this;
    }

    public function getHeaderRequest(): ?string
    {
        return json_encode($this->headerRequest);
    }

    public function setHeaderRequest(string $headerRequest): self
    {
        $this->headerRequest = json_decode($headerRequest,true);

        return $this;
    }

    public function getBodyRequest(): ?string
    {
        return $this->bodyRequest;
    }

    public function setBodyRequest(string $bodyRequest): self
    {
        $this->bodyRequest = $bodyRequest;

        return $this;
    }

    public function getHeaderResponse(): ?string
    {
        return json_encode($this->headerResponse);
    }

    public function setHeaderResponse(string $headerResponse): self
    {
        $this->headerResponse = json_decode($headerResponse,true);

        return $this;
    }

    public function getBodyResponse(): ?string
    {
        return $this->bodyResponse;
    }

    public function setBodyResponse(string $bodyResponse): self
    {
        $this->bodyResponse = $bodyResponse;

        return $this;
    }
}
