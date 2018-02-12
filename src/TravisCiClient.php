<?php

namespace Drupal\travisci_api;

use GuzzleHttp\Client;
use GuzzleHttp\Command\Guzzle\GuzzleClient;
use Drupal\service_description\Loader\DescriptionLoader;
use Drupal\Core\Config\ConfigFactory;

/**
 * Class TravisCiClient.
 */
class TravisCiClient extends GuzzleClient {

  /**
   * GuzzleHttp\Client definition.
   *
   * @var \GuzzleHttp\Client
   */
  protected $httpClient;

  /**
   * Drupal\service_description\Loader\DescriptionLoader definition.
   *
   * @var \Drupal\service_description\Loader\DescriptionLoader
   */
  protected $serviceDescriptionLoader;

  /**
   * Travis ci configuration.
   *
   * @var \Drupal\Core\Config\Config|\Drupal\Core\Config\ImmutableConfig
   */
  public $travisciConfig;

  /**
   * Constructs a new TravisCiClient object.
   */
  public function __construct(Client $http_client, DescriptionLoader $service_description_loader, ConfigFactory $config) {
    $this->httpClient = $http_client;
    $this->serviceDescriptionLoader = $service_description_loader;
    $this->travisciConfig = $config->get('travisci_api.travisciconfig');
    parent::__construct($this->httpClient, $this->serviceDescriptionLoader->load('travisci_api'));
  }

  /**
   * Make repo request.
   *
   * @param string $repo_name
   *   Repo name.
   * @param array $request
   *   Request.
   *
   * @see https://docs.travis-ci.com/user/triggering-builds/
   *
   * @return object
   *   Repo request response.
   */
  public function repoRequest($repo_name, array $request) {
    return $this->Request([
      'repo_name' => $repo_name,
      'request' => $request,
      'Authorization' => 'token ' . $this->travisciConfig->get('token'),
    ]);
  }

}
