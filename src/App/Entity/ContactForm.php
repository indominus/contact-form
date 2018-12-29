<?php
namespace App\Entity;

/**
 * 
 * @Entity
 * @Table(name="contact_form")
 */
class ContactForm
{

    const TYPE_PHPMAILER = 'phpmailer';
    const TYPE_SWIFTMAILER = 'swiftmailer';

    /**
     *
     * @var int
     * 
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /**
     *
     * @var string
     * 
     * @Column(type="string")
     */
    protected $type = self::TYPE_SWIFTMAILER;

    /**
     *
     * @var int
     * 
     * @Column(type="integer")
     */
    protected $code = 0;

    /**
     *
     * @var string
     * 
     * @Column(type="text", nullable=true)
     */
    protected $status;

    /**
     *
     * @var string
     * 
     * @Column(type="string")
     */
    protected $sender;

    /**
     *
     * @var string
     * 
     * @Column(type="string")
     */
    protected $receiver;

    public function getId()
    {
        return $this->id;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getSender()
    {
        return $this->sender;
    }

    public function getReceiver()
    {
        return $this->receiver;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function setCode($code)
    {
        $this->code = $code;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function setSender($sender)
    {
        $this->sender = $sender;
    }

    public function setReceiver($receiver)
    {
        $this->receiver = $receiver;
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }

    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     *
     * @var string
     * 
     * @Column(type="string")
     */
    protected $subject;

    /**
     *
     * @var string
     * 
     * @Column(type="text")
     */
    protected $message;

    /**
     *
     * @var \DateTime
     * 
     * @Column(type="datetime")
     */
    protected $createdAt;

}
