<?php

require_once 'Utils.php';
require_once 'ImplementationBase.php';

class Bitbucket extends ImplementationBase {

  const PUSH_EVENT_NAME = 'repo:push';

  /**
   * https://bitbucket.org/site/master/issues/12195/webhook-hmac-signature-security-issue#comment-29905282
   * @param $secret
   * @throws Exception
   */
  public function auth ($secret) {
    $getToken = Utils::getParam('secret', true);
    if (!hash_equals($secret, $getToken)) {
      throw new Exception('Hook secret does not match.');
    }
  }

  /**
   * @return string
   * @throws Exception
   */
  public function getEvent () {
    return Utils::getHeader($this->headers, 'X-Event-Key', true);
  }

  /**
   * @return string
   */
  protected function getPushEventName () {
    return self::PUSH_EVENT_NAME;
  }

  /**
   * @return string
   * @throws Exception
   */
  protected function getDeliveryId () {
    return Utils::getHeader($this->headers, 'X-Request-Uuid', true);
  }
}
