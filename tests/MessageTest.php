<?php
/**
 * @author Alexey Samoylov <alexey.samoylov@gmail.com>
 */
class MessageTest extends \PHPUnit\Framework\TestCase
{
    /** @var YarCode\Yii2\Mailgun\Message */
    public $a;

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function setUp()
    {
        parent::setUp();
        $this->a = \Yii::createObject(\YarCode\Yii2\Mailgun\Message::class);
    }

    public function testGetMessageBuilder()
    {
        $this->assertInstanceOf(\Mailgun\Messages\MessageBuilder::class, $this->a->getMessageBuilder());
    }

    public function testAttachContent()
    {
        $r = $this->a->attach('test');
        $this->assertSame($this->a, $r);
    }
}