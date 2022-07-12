<?php

namespace App\Repositories;

use App\Contracts\OrderContract;
use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class OrderRepositories extends BaseRepository implements OrderContract {
	
	public function __construct( Model $model ) {
		parent::__construct( $model );
		$this->model = $model;
	}
	
	public function storeOrderDetails( $params ) {
		$order = Order::create( [
									'order_number' => 'ORD-' . Str::upper(),
									'user_id'      => auth()->user()->id,
									'status'       => 'pending',
									'grand_total'  =>,
'item_count'                                       =>,
'payment_status'                                   =>,
'payment_method'                                   =>,
'first_name'                                       =>,
'last_name'                                        =>,
'address'                                          =>,
'city'                                             =>,
'country'                                          =>,
'post_code'                                        =>,
'phone_number'                                     =>,
'notes'                                            =>,
								] );
	}
	
	public function listOrders( string $order = 'id',
								string $sort = 'desc',
								array  $columns = [ '*' ] ) {
		// TODO: Implement listOrders() method.
	}
	
	public function findOrderByNumber( $orderNumber ) {
		// TODO: Implement findOrderByNumber() method.
	}
}