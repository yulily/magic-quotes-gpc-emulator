<?php

require_once './vendor/autoload.php';

class MagicQuotesGpcEmulatorTest extends PHPUnit\Framework\TestCase {
  public function setUp(): void
  {
      parent::setUp();
      ini_set('error_reporting', E_ALL & ~ E_DEPRECATED);

      $_GET = [
        "foo" => "fo'o",
        "bar" => "ba\"r",
        "baz" => "ba\z",
        "qux" => "qu" . chr(0) . "x",
      ];

      $_POST = [
        "foo" => "fo'o",
        "bar" => "ba\"r",
        "baz" => "ba\z",
        "qux" => "qu" . chr(0) . "x",
      ];

      $_COOKIE = [
        "foo" => "fo'o",
        "bar" => "ba\"r",
        "baz" => "ba\z",
        "qux" => "qu" . chr(0) . "x",
      ];

      $_REQUEST = [
        "foo" => "fo'o",
        "bar" => "ba\"r",
        "baz" => "ba\z",
        "qux" => "qu" . chr(0) . "x",
      ];
  }

  /**
  * @test
  */
  public function testBeforeApply() {
    $emulator = new Takapi86\MagicQuotesGpcEmulator();
    $this->assertFalse($emulator->isApplied());
    $this->assertFalse($emulator->isMagicQuotesGpcEnabled());
  }

  /**
  * @test
  */
  public function testApply() {
    $emulator = new Takapi86\MagicQuotesGpcEmulator();
    $emulator->apply();

    $expectGetValues = [
      "foo" => "fo\\'o",
      "bar" => "ba\\\"r",
      "baz" => "ba\\\\z",
      "qux" => "qu\\0x",
    ];

    $expectPostValues = [
      "foo" => "fo\\'o",
      "bar" => "ba\\\"r",
      "baz" => "ba\\\\z",
      "qux" => "qu\\0x",
    ];

    $expectCookieValues = [
      "foo" => "fo\\'o",
      "bar" => "ba\\\"r",
      "baz" => "ba\\\\z",
      "qux" => "qu\\0x",
    ];

    $expectRequestValues = [
      "foo" => "fo\\'o",
      "bar" => "ba\\\"r",
      "baz" => "ba\\\\z",
      "qux" => "qu\\0x",
    ];

    $this->assertEquals($_GET, $expectGetValues);
    $this->assertEquals($_POST, $expectPostValues);
    $this->assertEquals($_COOKIE, $expectCookieValues);
    $this->assertEquals($_REQUEST, $expectRequestValues);

    // second apply
    $emulator->apply();
    $this->assertEquals($_GET, $expectGetValues);
    $this->assertEquals($_POST, $expectPostValues);
    $this->assertEquals($_COOKIE, $expectCookieValues);
    $this->assertEquals($_REQUEST, $expectRequestValues);
  }

  /**
  * @test
  */
  public function testAfterApply() {
    $emulator = new Takapi86\MagicQuotesGpcEmulator();
    $this->assertTrue($emulator->isApplied());
    $this->assertTrue($emulator->isMagicQuotesGpcEnabled());
  }
}
