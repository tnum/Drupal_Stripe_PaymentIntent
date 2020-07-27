<?php

namespace Drupal\stripe_payment\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a card payment block.
 *
 * @Block(
 *   id = "stripe_card_payment",
 *   admin_label = @Translation("Stripe Payment: Card Payment Block"),
 *   category = @Translation("Stripe Payment")
 * )
 */
class CardPaymentBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    return [
      '#theme' => 'card_payment',
      '#attached' => [
        'library' => [
          'stripe_payment/example-one',
        ],
      ],
    ];
  }

}
