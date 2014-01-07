<?php

namespace ApiModule;

use \models\ApiErrorMsg;
use Nette\Image;
use \Nette\Application\UI\Form;

/**
 * Description of Homepage
 *
 */
class CampaignPresenter extends BasePresenter {

	/** @autowire @var \HQ\Model\Entity\DailyStatsEntity */
	protected $dailyStatsModel;

	public function actionDefault() {
		$networkCode = $this->getHttpRequest()->getQuery('network_code');
		$campaignCode = $this->getHttpRequest()->getQuery('campaign_code');
		
		$dailyStats = $this->dailyStatsModel->getStatsForCampaign($networkCode, $campaignCode);
		
		$ret = array(
			'clicks_cnt' => $dailyStats['clicks_cnt'],
			'downloads_cnt' => $dailyStats['downloads_cnt'],
			'network_code' => $networkCode,
			'campaign_code' => $campaignCode,
			'last_update_date' => $dailyStats['last_update_date']->format('Y-m-d H:i:s')
		);
		
		$this->prepareAndSendValidResponse($ret);
	}

}