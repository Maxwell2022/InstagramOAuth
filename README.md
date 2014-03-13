[![Total Downloads](https://poser.pugx.org/maxwell2022/instagram-oauth/downloads.png)](https://packagist.org/packages/maxwell2022/instagram-oauth)

This API is based on https://github.com/maxwell2022/twitteroauth

InstagramOAuth
------------

PHP library for working with Instagram's OAuth API.

Flow Overview
=============

1. Build InstagramOAuth object using client credentials.
2. Request temporary credentials from Instagram.
3. Build authorize URL for Instagram.
4. Redirect user to authorize URL.
5. User authorizes access and returns from Instagram.
6. Rebuild InstagramOAuth object with client credentials and temporary credentials.
7. Get token credentials from Instagram.
8. Rebuild InstagramOAuth object with client credentials and token credentials.
9. Query Instagram API.
