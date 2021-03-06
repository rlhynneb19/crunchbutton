<?php

class Controller_api_dashboard_beta extends Crunchbutton_Controller_RestAccount {
	public function init() {
		if (!c::admin()->permission()->check(['global', 'support-all', 'support-view', 'support-crud'])) {
			$this->error(401, true);
		}
		switch (c::getPagePiece(3)) {
			case 'communities-with-shift':
				$out = [];
				$communities = Dashboard::communitiesWithShits();
				foreach($communities as $community){
					$dashboard = new Dashboard($community);
					$out[] = $dashboard->statusByCommunity($community);
				}
				usort($out, function( $a, $b ) {
					return( $a[ 'total_undelivered_orders' ] < $b[ 'total_undelivered_orders' ] );
				} );
				echo json_encode( $out );exit;
				break;
			case 'pre-orders':
				$out = [];
				$orders = Dashboard::preOrders();
				foreach($orders as $order){
					$out[] = $order;
				}
				echo json_encode( $out );exit;
				break;
			case 'communities':
				$out = [];
				$communities = $this->request()[ 'communities' ];
				if(count($communities)){
					foreach($communities as $community){
						$dashboard = new Dashboard($community);
						$out[] = $dashboard->statusByCommunity($community);
					}
				}
				usort($out, function( $a, $b ) {
					return( $a[ 'total_undelivered_orders' ] < $b[ 'total_undelivered_orders' ] );
				} );
				echo json_encode( $out );exit;
				break;
			case 'current-driver-status':
				echo json_encode(Dashboard::driverStatus());exit;
				break;
			case 'chart-last-orders':
				echo json_encode(Dashboard::lastOrdersByHour());exit;
				break;
		}
	}
}
