<?php

namespace App\Repositories;

use App\Contracts\OrderContract;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Darryldecode\Cart\Cart;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class OrderRepositories extends BaseRepository implements OrderContract {
	
	public function __construct( Model $model ) {
		parent::__construct( $model );
		$this->model = $model;
	}
	
	public function storeOrderDetails( $params ) {
		$order = Order::create( [
									'order_number'   => 'ORD-' . Str::upper( uniqid() ),
									'user_id'        => auth()->user()->id,
									'status'         => 'pending',
									'grand_total'    => Cart::getSubTotal(),
									'item_count'     => Cart::getTotalQuantity(),
									'payment_status' => 0,
									'payment_method' => null,
									'first_name'     => $params[ 'first_name' ],
									'last_name'      => $params[ 'last_name' ],
									'address'        => $params[ 'address' ],
									'city'           => $params[ 'city' ],
									'country'        => $params[ 'country' ],
									'post_code'      => $params[ 'post_code' ],
									'phone_number'   => $params[ 'phone_number' ],
									'notes'          => $params[ 'notes' ],
								] );
		if( $order ) {
			$items = Cart::getContent();
			foreach( $items as $item ) {
				$product   = Product::where( 'name',
											 $item->id )
									->first();
				$orderItem = new OrderItem( [
												'product_id' => $product->id,
												'quantity'   => $product->quantity,
												'price'      => $product->price,
											] );
				$order->items()
					  ->save( $orderItem );
			}
		}
		return $order;
	}
	
	public function listOrders( string $order = 'id',
								string $sort = 'desc',
								array  $columns = [ '*' ] ) {
		return $this->all( $columns,
						   $order,
						   $sort );
	}
	
	public function findOrderByNumber( $orderNumber ) {
		return Order::where( 'order_number',
							 $orderNumber );
	}
}