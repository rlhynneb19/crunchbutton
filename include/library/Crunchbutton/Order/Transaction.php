<?php

class Crunchbutton_Order_Transaction extends Cana_Table {

	const TYPE_DEBIT = 'debit';
	const TYPE_CREDIT = 'credit';

	const TYPE_PAID_TO_RESTAURANT = 'paid-to-restaurant';
	const TYPE_PAID_TO_DRIVER = 'paid-to-driver';
	const TYPE_REFUNDED = 'refunded';
	const TYPE_REIMBURSED_TO_DRIVER = 'reimbursed-driver';
	const PAYMENT_TYPE_GIFT = 'gift';
	const PAYMENT_TYPE_CARD = 'card';

	const SOURCE_CRUNCHBUTTON = 'crunchbutton';
	const SOURCE_RESTAURANT = 'restaurant';

	public function checkOrderWasPaidRestaurant( $id_order ){
		$query = 'SELECT * FROM order_transaction ot WHERE type = ? AND id_order = ? LIMIT 1';
		$order = Crunchbutton_Order_Transaction::q( $query, [Crunchbutton_Order_Transaction::TYPE_PAID_TO_RESTAURANT, $id_order]);
		if( $order->id_order_transaction ){
			return true;
		}
		return false;
	}

	public function checkOrderWasReimbursedDriver( $id_order ){
		$query = 'SELECT * FROM order_transaction ot WHERE type = ? AND id_order = ? LIMIT 1';
		$order = Crunchbutton_Order_Transaction::q( $query, [Crunchbutton_Order_Transaction::TYPE_REIMBURSED_TO_DRIVER, $id_order]);
		if( $order->id_order_transaction ){
			return true;
		}
		return false;
	}

	public function checkOrderWasPaidDriver( $id_order ){
		$query = 'SELECT * FROM order_transaction ot WHERE type = ? AND id_order = ? LIMIT 1';
		$order = Crunchbutton_Order_Transaction::q( $query, [Crunchbutton_Order_Transaction::TYPE_PAID_TO_DRIVER, $id_order]);
		if( $order->id_order_transaction ){
			return true;
		}
		return false;
	}

	public function orderReimbursementInfoDriver( $id_order ){
		$query = 'SELECT p.* FROM order_transaction ot
								INNER JOIN payment_order_transaction pot ON pot.id_order_transaction = ot.id_order_transaction
								INNER JOIN payment p ON p.id_payment = pot.id_payment
								WHERE type = ? AND id_order = ? LIMIT 1';
		$payment = Crunchbutton_Payment::q( $query, [Crunchbutton_Order_Transaction::TYPE_REIMBURSED_TO_DRIVER, $id_order]);
		if( $payment->id_payment ){
			return $payment->get( 0 );
		}
		return false;
	}

	public function orderPaymentInfoDriver( $id_order ){
		$query = 'SELECT p.* FROM order_transaction ot
								INNER JOIN payment_order_transaction pot ON pot.id_order_transaction = ot.id_order_transaction
								INNER JOIN payment p ON p.id_payment = pot.id_payment
								WHERE type = ? AND id_order = ? LIMIT 1';
		$payment = Crunchbutton_Payment::q( $query, [Crunchbutton_Order_Transaction::TYPE_PAID_TO_DRIVER, $id_order]);
		if( $payment->id_payment ){
			return $payment->get( 0 );
		}
		return false;
	}

	public function __construct($id = null) {
		parent::__construct();
		$this
			->table('order_transaction')
			->idVar('id_order_transaction')
			->load($id);
	}
}