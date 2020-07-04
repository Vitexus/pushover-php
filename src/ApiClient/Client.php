<?php

/*
 * This file is part of the Pushover package.
 *
 * (c) Serhiy Lunak <https://github.com/slunak>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Serhiy\Pushover\ApiClient;

use Serhiy\Pushover\ApiClient\Message\MessageResponse;
use Serhiy\Pushover\ApiClient\Receipts\CancelRetryResponse;
use Serhiy\Pushover\ApiClient\Receipts\ReceiptResponse;
use Serhiy\Pushover\ApiClient\UserGroupValidation\UserGroupValidationResponse;

/**
 * Base class for the API client.
 *
 * @author Serhiy Lunak
 */
class Client
{
    /**
     * Sends request and returns response object.
     *
     * @param Request $request
     * @return MessageResponse|UserGroupValidationResponse|ReceiptResponse|CancelRetryResponse
     */
    public function send(Request $request)
    {
        $curlResponse = CurlHelper::do($request);

        $response = $this->processCurlResponse($curlResponse);
        $response->setRequest($request);

        return $response;
    }
}
