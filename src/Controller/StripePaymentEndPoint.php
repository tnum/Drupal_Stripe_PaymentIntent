<?php

namespace Drupal\stripe_payment\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\Core\Site\Settings;
use Stripe\Stripe;
use Stripe\PaymentIntent;

/**
 * Route response for Stripe.
 */
class StripePaymentEndPoint extends ControllerBase {

  /**
   * The settings object.
   *
   * @var Drupal\Core\Site\Settings
   */
  private $settings;

  /**
   * {@inheritdoc}
   */
  public function __construct(Settings $settings) {
    $this->settings = $settings;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('settings')
    );
  }

  /**
   * Captures the data in the Stripe webhook.
   */
  public function captureNotification(Request $request) {

    $api_key = $this->settings->get('stripe_webhooks_api_key');

    Stripe::setApiKey($api_key);

    try {

      if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        $data = json_decode($request->getContent(), TRUE);
        $request->request->replace(is_array($data) ? $data : []);
      }

      $paymentIntent = PaymentIntent::create([
        'amount' => $data['price'],
        'currency' => 'gbp',
        'description' => $data['description'],
      ]);

      $output = [
        'clientSecret' => $paymentIntent->client_secret,
      ];

      $response['data'] = $output;
      $response['method'] = 'POST';

      return new JsonResponse($response);
    }
    catch (Error $e) {
      http_response_code(500);
      json_encode(['error' => $e->getMessage()]);
    }

    $response = new JsonResponse();
    $response->setContent('Success!');

    return $response;
  }

}
