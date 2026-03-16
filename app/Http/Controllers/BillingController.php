<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BillingController extends Controller
{
    // Stripe Checkout للاشتراك
    public function checkout()
    {
        $user = auth()->user();

        if ($user->isPro()) {
            return $this->portal();
        }

        $checkout = $user->newSubscription('default', env('STRIPE_PRO_PRICE_ID'))
            ->checkout([
                'success_url' => route('billing.success'),
                'cancel_url'  => url('/app'),
            ]);

        return redirect($checkout->url);
    }

    // Stripe Customer Portal للإدارة والإلغاء
    public function portal()
    {
        $url = auth()->user()->billingPortalUrl(url('/app'));
        return redirect($url);
    }

    // بعد الدفع الناجح
    public function success()
    {
        return view('billing.success');
    }
}