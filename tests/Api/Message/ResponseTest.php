<?php

/*
 * This file is part of the Pushover package.
 *
 * (c) Serhiy Lunak <https://github.com/slunak>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Api\Message;

use PHPUnit\Framework\TestCase;
use Serhiy\Pushover\Api\Message\Client;
use Serhiy\Pushover\Api\Message\Message;
use Serhiy\Pushover\Api\Message\Notification;
use Serhiy\Pushover\Api\Message\Response;
use Serhiy\Pushover\Application;
use Serhiy\Pushover\Recipient;

/**
 * @author Serhiy Lunak
 */
class ResponseTest extends TestCase
{
    public function testCanBeCrated()
    {
        $response = new Response();

        $this->assertInstanceOf(Response::class, $response);
    }

    public function testRealResponseForInvalidRequest()
    {
        $application = new Application("azGDORePK8gMaC0QOYAMyEEuzJnyUi"); // using dummy token
        $recipient = new Recipient("uQiRzpo4DXghDmr9QzzfQu27cmVRsG"); // using dummy user key
        $message = new Message("This is a test message", "This is a title of the message");
        $notification = new Notification($application, $recipient, $message);
        $client = new Client();

        $response = $client->push($notification);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(false, $response->isSuccessful());
        $this->assertEquals(0, $response->getRequestStatus());
        $this->assertEquals("invalid", json_decode($response->getCurlResponse())->token);
    }
}
