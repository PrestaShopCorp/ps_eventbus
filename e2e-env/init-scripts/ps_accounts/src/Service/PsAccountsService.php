<?php

namespace PrestaShop\Module\PsAccounts\Service;

class PsAccountsService
{
    public function __construct()
    {
    }

    public function getSuperAdminEmail()
    {
        return 'qa-autom@prestashop.com';
    }

    public function getShopUuid()
    {
        return 'f07181f7-2399-406d-9226-4b6c14cf6068';
    }

    public function getOrRefreshToken()
    {
        return 'eyJhbGciOiJSUzI1NiIsImtpZCI6IjFlOTczZWUwZTE2ZjdlZWY0ZjkyMWQ1MGRjNjFkNzBiMmVmZWZjMTkiLCJ0eXAiOiJKV1QifQ.eyJpc3MiOiJodHRwczovL3NlY3VyZXRva2VuLmdvb2dsZS5jb20vcHJlc3Rhc2hvcC1yZWFkeS1wcm9kIiwiYXVkIjoicHJlc3Rhc2hvcC1yZWFkeS1wcm9kIiwiYXV0aF90aW1lIjoxNjc5MDY1NzE0LCJ1c2VyX2lkIjoiZjA3MTgxZjctMjM5OS00MDZkLTkyMjYtNGI2YzE0Y2Y2MDY4Iiwic3ViIjoiZjA3MTgxZjctMjM5OS00MDZkLTkyMjYtNGI2YzE0Y2Y2MDY4IiwiaWF0IjoxNjc5MDY1NzE0LCJleHAiOjE2NzkwNjkzMTQsImVtYWlsIjoiaHR0cGM4MTg4ODE2Mjc1NjVldW5ncm9raW8xQHNob3AucHJlc3Rhc2hvcC5jb20iLCJlbWFpbF92ZXJpZmllZCI6dHJ1ZSwiZmlyZWJhc2UiOnsiaWRlbnRpdGllcyI6eyJlbWFpbCI6WyJodHRwYzgxODg4MTYyNzU2NWV1bmdyb2tpbzFAc2hvcC5wcmVzdGFzaG9wLmNvbSJdfSwic2lnbl9pbl9wcm92aWRlciI6ImN1c3RvbSJ9fQ.mbv_nY6rmz_OpfN32CyvsTa-ahlUO9FD1cok24HrZHNGkR-ZD6OzXvHedcFtU0RpafAdDdTYcU3GW_kiN_lqNwrbA2uO8LAS-JdQT1E1BFkhengrxFt8Gh_lBm_yE4B6DngvAs-6SGctmNxOc-wfWA3AC_CXKpJviu1P08tz7nYRwAQw_6EH1XaDVl9Cva51cCWUTFzWZ5VHgBUA-GdAyEbLkL9M9rRk0hy-KERwW-2plV_Mu5tpfnFUYZx2ZWwn-_ODEFyindyKiimuwZ6FF5p0pfZxfbMA_EXUdCsUlg1DMlv8zari-50PkhsnkD_DQ-dbmgpiKuM3ZFnL6vCSVw';
    }

    public function getRefreshToken()
    {
        return 'APJWN8eGz3m00UaeLKn80vFqoqzcQY5R39Uv78i8spcsKwg5j2SSzYKL5YyDk_bfTdJ8NLsn-L5YzmlpSasS3Ysj_kv2HJatbZg91v90tEHLXGh7lA_p_avWik8P5XTcXXn3bjGNh7VoDYS1nJhQPmYGyIrjNEv0yGewGkheWxrDstIKPuPuDQSmlJZtKdQVLYes1b27Ybi8NKvAtFKmmXvNCOlG_ZH3YQ';
    }

    public function getToken()
    {
        return 'eyJhbGciOiJSUzI1NiIsImtpZCI6IjFlOTczZWUwZTE2ZjdlZWY0ZjkyMWQ1MGRjNjFkNzBiMmVmZWZjMTkiLCJ0eXAiOiJKV1QifQ.eyJpc3MiOiJodHRwczovL3NlY3VyZXRva2VuLmdvb2dsZS5jb20vcHJlc3Rhc2hvcC1yZWFkeS1wcm9kIiwiYXVkIjoicHJlc3Rhc2hvcC1yZWFkeS1wcm9kIiwiYXV0aF90aW1lIjoxNjc5MDY1NzE0LCJ1c2VyX2lkIjoiZjA3MTgxZjctMjM5OS00MDZkLTkyMjYtNGI2YzE0Y2Y2MDY4Iiwic3ViIjoiZjA3MTgxZjctMjM5OS00MDZkLTkyMjYtNGI2YzE0Y2Y2MDY4IiwiaWF0IjoxNjc5MDY1NzE0LCJleHAiOjE2NzkwNjkzMTQsImVtYWlsIjoiaHR0cGM4MTg4ODE2Mjc1NjVldW5ncm9raW8xQHNob3AucHJlc3Rhc2hvcC5jb20iLCJlbWFpbF92ZXJpZmllZCI6dHJ1ZSwiZmlyZWJhc2UiOnsiaWRlbnRpdGllcyI6eyJlbWFpbCI6WyJodHRwYzgxODg4MTYyNzU2NWV1bmdyb2tpbzFAc2hvcC5wcmVzdGFzaG9wLmNvbSJdfSwic2lnbl9pbl9wcm92aWRlciI6ImN1c3RvbSJ9fQ.mbv_nY6rmz_OpfN32CyvsTa-ahlUO9FD1cok24HrZHNGkR-ZD6OzXvHedcFtU0RpafAdDdTYcU3GW_kiN_lqNwrbA2uO8LAS-JdQT1E1BFkhengrxFt8Gh_lBm_yE4B6DngvAs-6SGctmNxOc-wfWA3AC_CXKpJviu1P08tz7nYRwAQw_6EH1XaDVl9Cva51cCWUTFzWZ5VHgBUA-GdAyEbLkL9M9rRk0hy-KERwW-2plV_Mu5tpfnFUYZx2ZWwn-_ODEFyindyKiimuwZ6FF5p0pfZxfbMA_EXUdCsUlg1DMlv8zari-50PkhsnkD_DQ-dbmgpiKuM3ZFnL6vCSVw';
    }

    public function getUserUuid()
    {
        return 'f07181f7-2399-406d-9226-4b6c14cf6068';
    }

    public function isEmailValidated()
    {
        return true;
    }

    public function getEmail()
    {
        return 'qa-autom@prestashop.com';
    }

    public function isAccountLinked()
    {
        return true;
    }

    public function isAccountLinkedV4()
    {
        return true;
    }
}
