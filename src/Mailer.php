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
     * @return Mailgun
     */
    public function getClient()
    {
        if (empty($this->client)) {
            $this->client = $this->createClient();
        }
        return $this->client;
    }

    /**
     * @return Mailgun
     * @throws InvalidConfigException
     */
    protected function createClient()
    {
        if (empty($this->apiKey) || empty($this->domain)) {
            throw new InvalidConfigException('Invalid mailer configuration');
        }
        return new Mailgun($this->apiKey);
    }

    /**
     * @param Message $message
     * @inheritdoc
     */
    protected function sendMessage($message)
    {
        $this->getClient()->post("{$this->domain}/messages",
            $message->getMessageBuilder()->getMessage(),
            $message->getMessageBuilder()->getFiles()
        );
        return true;
    }
}