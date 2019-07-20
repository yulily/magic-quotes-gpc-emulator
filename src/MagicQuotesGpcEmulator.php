<?php

class MagicQuotesGpcEmulator {
  public function apply() {
    $_GET = $this->add_magic_quotes($_GET);
    $_POST = $this->add_magic_quotes($_POST);
    $_COOKIE = $this->add_magic_quotes($_COOKIE);

    $_REQUEST = array_merge($_GET, $_POST);
  }

  private function add_magic_quotes( $array ) {
    foreach ((array) $array as $k => $v) {
        if (is_array( $v)) {
            $array[$k] = add_magic_quotes($v);
        } else {
            $array[$k] = addslashes($v);
        }
    }

    return $array;
  }
}
