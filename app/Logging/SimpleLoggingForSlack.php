<?php

namespace App\Logging;

use Illuminate\Log\Logger;
use Monolog\Handler\SlackWebhookHandler;

class SimpleLoggingForSlack
{
    public function __invoke(Logger $logger): void
    {
        foreach ($logger->getHandlers() as $handler) {
            if ($handler instanceof SlackWebhookHandler) {
                $handler->getSlackRecord()
                    ->includeContextAndExtra(false)
                    ->useShortAttachment(true);
            }
        }
    }
}
