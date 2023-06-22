<?php
class PsAccountsServiceMock
{
  /**
   * Mock a refresh token getter/refresher
   *
   * @return string
   *
   * @throws \Exception
   */
  public function getOrRefreshToken() {
    $token = 'coucou';
    return (string) $token;
  }

  /**
   * Mock a shopId getter
   * @return string|false
   */
  public function getShopUuid() {
    $shopId = '00000000-0000-0000-0000-000000000000';
    return $shopId;
  }
}

class Ps_accounts_mock
{
  public function getPsAccountsService ()
  {
    return new PsAccountsServiceMock();
  }
}
?>
