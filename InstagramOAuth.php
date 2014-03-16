<?php

namespace Maxwell\Instagram;

use Maxwell\OAuthClient\AbstractOAuthClient;
use Maxwell\OAuthClient\OAuth;

/**
 * Instagram OAuth class
 */
class InstagramOAuth extends AbstractOAuthClient
{
    const ACCESS_TOKEN_URL = 'https://api.instagram.com/oauth/access_token';
    const AUTHENTICATE_URL = 'https://api.instagram.com/oauth/authorize';
    const AUTHORIZE_URL = 'https://api.instagram.com/oauth/authorize';
    const REQUEST_TOKEN_URL = 'https://api.instagram.com/oauth/authorize';

    const API_ENTRY_POINT = 'https://api.instagram.com/v1/';

    /**
     * Get the authorize URL
     *
     * @param null $redirectURI
     * @param string $scope
     * @param null $state
     * @param string $responseType
     *
     * @return string
     */
    function getAuthorizeURL($redirectURI = null, $scope = 'basic', $state = null, $responseType = 'code')
    {
        $params = array(
            'client_id' => $this->getConsumerKey(),
            'scope' => $scope,
            'response_type' => $responseType,
            'redirect_uri' => $this->getRedirectUri($redirectURI)
        );

        if (null !== $state) {
            $params['state'] = $state;
        }

        return self::AUTHORIZE_URL . '?' . http_build_query($params);
    }

    /**
     * Exchange request token and secret for an access token and
     * secret, to sign API calls.
     *
     * @param string $code
     * @param string|null $redirectURI
     *
     * @return mixed
     */
    function getAccessToken($code, $redirectURI = null)
    {
        $params = array(
            'code' => $code,
            'client_id' => $this->getConsumerKey(),
            'client_secret' => $this->getConsumerSecret(),
            'grant_type' => 'authorization_code',
            'redirect_uri' => $this->getRedirectUri($redirectURI)
        );

        return $this->post(self::ACCESS_TOKEN_URL, $params);
    }

    /**
     * Request the API
     *
     * @param $uri
     * @param string $method
     * @param array $parameters
     * @return array|string
     */
    public function request($uri, $method='GET', $parameters=array())
    {
        // Query parameters needed to make a basic OAuth transaction
        $params = array(
            'format' => self::DEFAULT_FORMAT,
        );

        $parameters = array_merge($params, $parameters);
        $url = $uri;

        if (!preg_match('#^http#i', $uri)) {

            // Remove starting slash if any
            if (preg_match('#^/#i', $uri)) {
                $uri = substr($uri, 1);
            }

            // Build the URL
            $url = self::API_ENTRY_POINT.$uri;
        }

        // build the http query
        if ('GET' === strtoupper(trim($method))) {
            $url .= '?' . http_build_query($parameters);
            $response = $this->http($url, 'GET');
        } else {
            $response = $this->http($url, $method, $parameters);
        }

        if ('json' == self::DEFAULT_FORMAT) {
            $json = json_decode($response, true);
            return null === $json ? $response : $json;
        }

        return $response;
    }

    /**
     * Publish a content on the social network
     *
     * @param $data
     * @return bool|void
     * @throws \Exception
     */
    public function publish($data)
    {
        throw new \Exception('Instagram does not support publication through API');
    }
}