<?php

/*
 * This file is part of the Pushover package.
 *
 * (c) Serhiy Lunak <https://github.com/slunak>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Serhiy\Pushover\Client\Response;

use Serhiy\Pushover\Client\Response\Base\Response;

/**
 * @author Serhiy Lunak
 */
class CancelRetryResponse extends Response
{
    /**
     * @param mixed $curlResponse
     */
    public function __construct($curlResponse)
    {
        $this->processCurlResponse($curlResponse);
    }

    /**
     * @param mixed $curlResponse
     */
    private function processCurlResponse($curlResponse): void
    {
        $decodedCurlResponse = json_decode($curlResponse);

        $this->setRequestStatus($decodedCurlResponse->status);
        $this->setCurlResponse($curlResponse);

        if ($this->getRequestStatus() == 1) {
            $this->setIsSuccessful(true);
            $this->setRequestToken($decodedCurlResponse->request);
        }

        if ($this->getRequestStatus() != 1) {
            $this->setErrors($decodedCurlResponse->errors);
            $this->setIsSuccessful(false);
        }
    }
}
