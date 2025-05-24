<?php

namespace Modules\Order\Traits;

use Cart;
use Darryldecode\Cart\CartCondition;

trait OrderCalculationTrait
{
    public function calculateTheOrder()
    {
        $total = $this->totalOrder();

        $order                            = $this->orderProducts();
        $order['address']                 = $this->orderAddress();
        $order['vendor_id']               = $this->orderVendor();
        $order['commission']              = $this->commissionFromVendor();
        $order['subtotal']                = $this->subtotalOrder();
        $order['shipping']                = $this->orderShipping();
        $order['total']                   = $total;
        $order['totalProfitCommission']   = number_format($order['commission'] + $order['profit'],3);

        return $order;
    }

    public function totalOrder()
    {
        return Cart::getTotal();
    }

    public function subtotalOrder()
    {
        return Cart::getSubTotal();
    }

    public function commissionFromVendor()
    {
        $commission = Cart::getCondition('commission')->getAttributes();

        $percentege = $commission['commission'] ? $this->totalOrder() * ( $commission['commission'] / 100) : 0.000;
        $fixed      = $commission['fixed_commission'] ? $commission['fixed_commission'] : 0.000;

        return $percentege + $fixed;
    }

    public function orderShipping()
    {
        return Cart::getCondition('delivery_fees')->getValue();
    }

    public function orderAddress()
    {
        return Cart::getCondition('delivery_fees')->getAttributes()['address'];
    }

    public function orderVendor()
    {
        return Cart::getCondition('vendor')->getType();
    }

    public function orderProducts()
    {
        $data           = [];
        $subtotal       = 0.000;
        $off            = 0.000;
        $price          = 0.000;
        $profite        = 0.000;
        $profitePrice   = 0.000;

        foreach (Cart::getContent() as $value) {

            $product['variant']               = ($value->attributes->type == 'variants') ?
                                                  $value->attributes->variant->id : null;

            $product['variant_values']        = ($value->attributes->type == 'variants') ?
                                                  $value->attributes->variant->productValues->pluck('id') : null;

            $product['product_id']            = ($value->attributes->type == 'variants') ?
                                                  $value->attributes->product->id :
                                                  $value->id;

            $product['original_price']        = ($value->attributes->type == 'variants') ?
                                                $value->attributes->variant->price :
                                                $value->attributes->product->price;

            $product['sku']                   = $value->attributes->sku;
            $product['quantity']              = $value->quantity;
            $product['sale_price']            = $value->price;
            $product['off']                   = $product['original_price'] - $product['sale_price'];
            $product['original_total']        = $product['original_price'] * $product['quantity'];
            $product['total']                 = $product['sale_price'] * $product['quantity'];
            $product['cost_price']            = $value->attributes->product->cost_price;
            $product['total_cost_price']      = $product['cost_price'] * $product['quantity'];
            $product['total_profit']          = $product['total'] -  $product['total_cost_price'];

            $off            +=  $product['off'];
            $price          +=  $product['total'];
            $subtotal       +=  $product['original_total'];
            $profitePrice   +=  $product['total_cost_price'];
            $profite        +=  $product['total_profit'];

            $data[] = $product;
        }

        return ['profit' => $profite , 'off'=> $off ,'original_subtotal' => $subtotal, 'products' => $data];
    }
}
