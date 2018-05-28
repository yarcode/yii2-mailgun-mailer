<?php
/**
 * @author Alexey Samoylov <alexey.samoylov@gmail.com>
 */
namespace YarCode\Yii2\Mailgun;

use Mailgun\Mailgun;
use yii\base\InvalidConfigException;
use yii\mail\BaseMailer;

class Mailer extends BaseMailer
{
    /** @var string */
    public $messageClass = Message::class;
    /** @var string */
    protected $apiKey;
    /** @var string */
    protected $domain;
    /** @var Mailgun */
    protected $client;

    /**
     * @throws InvalidConfigException
     */
    public function init()
    {
        parent::init();
        if (!isset($this->apiKey, $this->domain)) {
            throw new InvalidConfigException('Invalid mailer configuration');
        }
        $this->client = \Yii::createObject(Mailgun::class, [$this->apiKey]);
    }

    /**
     * @param string $apiKey
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @param string $domain
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;
    }

    /**
     * @param Message $message
     * @inheritdoc
     */
    protected function sendMessage($message)
    {
        $this->client->post("{$this->domain}/messages",
            $message->getMessageBuilder()->getMessage(),
            $message->getMessageBuilder()->getFiles()
        );
        return true;
    }
}