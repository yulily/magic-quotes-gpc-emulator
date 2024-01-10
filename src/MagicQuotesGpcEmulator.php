<?php

namespace Takapi86;

class MagicQuotesGpcEmulator {
  public function apply() {
    if ($this->isMagicQuotesGpcEnabled()) {
      return;
    }

    $_GET = filter_var_array($_GET, FILTER_SANITIZE_ADD_SLASHES);
    $_POST = filter_var_array($_POST, FILTER_SANITIZE_ADD_SLASHES);
    $_COOKIE = filter_var_array($_COOKIE, FILTER_SANITIZE_ADD_SLASHES);
    $_REQUEST = filter_var_array($_REQUEST, FILTER_SANITIZE_ADD_SLASHES);

    define('MagicQuotesGpcEmulatorApplied', true);
  }

  public function isApplied() {
    return defined('MagicQuotesGpcEmulatorApplied');
  }

  public function isMagicQuotesGpcEnabled() {
    if ($this->isApplied()) {
      return true;
    }
    if (!function_exists('get_magic_quotes_gpc')) {
      return false;
    }
    return get_magic_quotes_gpc();
  }
}
