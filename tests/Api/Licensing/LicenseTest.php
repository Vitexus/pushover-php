<?php

/**
 * This file is part of the Pushover package.
 *
 * (c) Serhiy Lunak <https://github.com/slunak>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Api\Licensing;

use Serhiy\Pushover\Api\Licensing\License;
use PHPUnit\Framework\TestCase;
use Serhiy\Pushover\Application;
use Serhiy\Pushover\Client\Response\LicenseResponse;
use Serhiy\Pushover\Exception\InvalidArgumentException;
use Serhiy\Pushover\Recipient;

class LicenseTest extends TestCase
{
    public function testCanBeCreated(): License
    {
        $application = new Application('cccc3333CCCC3333dddd4444DDDD44'); // using dummy token
        $license = new License($application);

        $this->assertInstanceOf(License::class, $license);

        return $license;
    }

    /**
     * @depends testCanBeCreated
     */
    public function testGetApplication(License $license): void
    {
        $this->assertInstanceOf(Application::class, $license->getApplication());
    }

    /**
     * @depends testCanBeCreated
     */
    public function testSetApplication(License $license): void
    {
        $application = new Application('cccc3333CCCC3333dddd4444DDDD44'); // using dummy token
        $license->setApplication($application);

        $this->assertInstanceOf(Application::class, $license->getApplication());
    }

    /**
     * @depends testCanBeCreated
     */
    public function testGetRecipient(License $license): void
    {
        $this->assertNull($license->getRecipient());
    }

    /**
     * @depends testCanBeCreated
     */
    public function testSetRecipient(License $license): void
    {
        $recipient = new Recipient('aaaa1111AAAA1111bbbb2222BBBB22'); // using dummy user key

        $license->setRecipient($recipient);
        $this->assertInstanceOf(Recipient::class, $license->getRecipient());

        $license->setRecipient(null);
        $this->assertNull($license->getRecipient());
    }

    /**
     * @depends testCanBeCreated
     */
    public function testGetEmail(License $license): void
    {
        $this->assertNull($license->getEmail());
    }

    /**
     * @depends testCanBeCreated
     */
    public function testSetEmail(License $license): void
    {
        $email = 'dummy@email.com';

        $license->setEmail($email);
        $this->assertEquals($email, $license->getEmail());

        $license->setEmail(null);
        $this->assertNull($license->getEmail());
    }

    /**
     * @depends testCanBeCreated
     */
    public function testGetOs(License $license): void
    {
        $this->assertNull($license->getOs());
    }

    /**
     * @depends testCanBeCreated
     */
    public function testSetOs(License $license): void
    {
        $license->setOs(License::OS_ANDROID);
        $this->assertEquals(License::OS_ANDROID, $license->getOs());

        $license->setOs(License::OS_ANY);
        $this->assertNull($license->getOs());

        $this->expectException(InvalidArgumentException::class);
        $license->setOs('Wrong_OS');
    }

    /**
     * @depends testCanBeCreated
     */
    public function testCanBeAssigned(License $license): void
    {
        $recipient = new Recipient('aaaa1111AAAA1111bbbb2222BBBB22'); // using dummy user key
        $email = 'dummy@email.com';

        $this->assertFalse($license->canBeAssigned());

        $license->setRecipient($recipient);
        $this->assertTrue($license->canBeAssigned());

        $license->setEmail($email);
        $this->assertTrue($license->canBeAssigned());

        $license->setRecipient(null);
        $this->assertTrue($license->canBeAssigned());

        $license->setEmail(null);
        $this->assertFalse($license->canBeAssigned());
    }

    /**
     * @depends testCanBeCreated
     */
    public function testGetAvailableOsTypes(License $license): void
    {
        $licenseTypes = [
            'OS_ANDROID' => 'Android',
            'OS_IOS' => 'iOS',
            'OS_DESKTOP' => 'Desktop',
            'OS_ANY' => null,
        ];

        $this->assertEquals($licenseTypes, $license->getAvailableOsTypes());
    }

    /**
     * @group Integration
     */
    public function testCheckCredits(): void
    {
        $application = new Application('cccc3333CCCC3333dddd4444DDDD44'); // using dummy token
        $license = new License($application);

        $response = $license->checkCredits();

        $this->assertInstanceOf(LicenseResponse::class, $response);
    }
}
