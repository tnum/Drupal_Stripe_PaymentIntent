# Stripe Payment

A simple Drupal 8 module for accepting payments using Stripe's PaymentIntent API.

Documentation can be found on the Stripe Docs page on [accepting a payment](https://stripe.com/docs/payments/accept-a-payment?lang=php).

## Installation

1. Sign up for a stripe account and find your API keys.

2. Add the following line to settings.php
`$settings['stripe_webhooks_api_key'] = 'YOUR_SECRET_KEY';`

3. In stripe_payment/js/example1.js replace `'YOUR_PUBLISHABLE_KEY'` with the publishable key from your Stripe account.

4. Run `composer require stripe/stripe-php` in the project root.
