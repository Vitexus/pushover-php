<?php

/*
 * This file is part of the Pushover package.
 *
 * (c) Serhiy Lunak <https://github.com/slunak>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Serhiy\Pushover\ApiClient\Message;

use Serhiy\Pushover\ApiClient\Response;

/**
 * @author Serhiy Lunak
 */
class MessageResponse extends Response
{
    /**
     * Receipt.
     * When your application sends an emergency-priority notification, our API will respond with a receipt value
     * that can be used to get information about whether the notification has been acknowledged.
     * See {@link https://pushover.net/api/receipts} for more information.
     *
     * @var string
     */
    private $receipt;

    public function __construct()
    {
    }

    /**
     * @return string
     */
    public function getReceipt(): string
    {
        return $this->receipt;
    }

    /**
     * @param string $receipt
     */
    public function setReceipt(string $receipt): void
    {
        $this->receipt = $receipt;
    }
}
