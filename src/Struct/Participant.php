<?php
/**
 * @filename: Participant.php
 */
declare(strict_types=1);

/** @namespace */
namespace ZendMailgun\Struct;

/**
 * Class Participant
 * @package ZendMailgun\Struct
 */
class Participant extends AbstractStruct
{
    /** @var string the participant's email address */
    protected $email;
    /** @var null|string the participant's name */
    protected $name;

    /**
     * @param string $email the participant's email address
     * @param string $name  the participant's name
     */
    public function __construct($email = null, $name = null)
    {
        $this->email = $email;
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return $this
     */
    public function setEmail(string $email): Participant
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName(string $name): Participant
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Prepare recipient for sending message
     * like 'User <user@mail.com>'
     *
     * @return string
     */
    public function prepare(): string
    {
        if (empty($this->getEmail())) {
            throw new \ZendMailgun\Exception\EmptyParticipantEmail;
        }

        return "{$this->getName()} <{$this->getEmail()}>";
    }
}