<?php

namespace M6Web\Component\RedisMessageBroker\MessageHandler\tests\units;

use \mageekguy\atoum;

use M6Web\Component\RedisMessageBroker\Queue\Definition;
use M6Web\Component\RedisMessageBroker\MessageEnvelope;

class Producer extends atoum\test
{
    public function testProducer()
    {
        $this
            ->if(
                $queue = new Definition('queue1'),
                $redisClient = new \mock\Predis\Client(),
                $producer = $this->newTestedInstance($queue, $redisClient),
                $message = new MessageEnvelope(uniqid(), 'message in the bottle')
            )
            ->then
                ->integer($producer->publishMessage($message))
                ->mock($redisClient)
                    ->call('lpush')
                        ->once()
        ;
    }
}