<?php

require_once './vendor/autoload.php';

class MagicQuotesGpcEmulatorTest extends PHPUnit\Framework\TestCase {
  public function setUp(): void
  {
      parent::setUp();

      $_GET = [
        "foo" => "fo'o",
        "bar" => "ba\"r",
        "baz" => "ba\z",
        "qux" => "qu" . chr(0) . "x",
        "getOnlyValue" => "getOnlyValue",
      ];

      $_POST = [
        "foo" => "fo'o",
        "bar" => "ba\"r",
        "baz" => "ba\z",
        "qux" => "qu" . chr(0) . "x",
        "postOnlyValue" => "postOnlyValue",
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
  public function testApply() {
    require_once './src/MagicQuotesGpcEmulator.php';
    $emulator = new MagicQuotesGpcEmulator();
    $emulator->apply();

    $expectGetValues = [
      "foo" => "fo\\'o",
      "bar" => "ba\\\"r",
      "baz" => "ba\\\\z",
      "qux" => "qu\\0x",
      "getOnlyValue" => "getOnlyValue",
    ];

    $expectPostValues = [
      "foo" => "fo\\'o",
      "bar" => "ba\\\"r",
      "baz" => "ba\\\\z",
      "qux" => "qu\\0x",
      "postOnlyValue" => "postOnlyValue",
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
      "getOnlyValue" => "getOnlyValue",
      "postOnlyValue" => "postOnlyValue",
    ];

    $this->assertEquals($_GET, $expectGetValues);
    $this->assertEquals($_POST, $expectPostValues);
    $this->assertEquals($_COOKIE, $expectCookieValues);
    $this->assertEquals($_REQUEST, $expectRequestValues);
  }
}
