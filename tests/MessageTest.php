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

    public function testInterface()
    {
        $this->assertInstanceOf(\yii\mail\MessageInterface::class, $this->a);
    }

    public function testGetMessageBuilder()
    {
        $this->assertInstanceOf(\Mailgun\Messages\MessageBuilder::class, $this->a->getMessageBuilder());
    }

    public function testAttachContent()
    {
        $r = $this->a->attachContent('test', [
            'fileName' => 'test.txt',
        ]);
        $this->assertSame($this->a, $r);
    }

    public function testToString()
    {
        $this->assertInternalType('string', $this->a->toString());
    }
}