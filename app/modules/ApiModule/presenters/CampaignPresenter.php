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
		$adgroupCode = $this->getHttpRequest()->getQuery('adgroup_code');
		
		$dailyStats = $this->dailyStatsModel->getStatsForCampaign($networkCode, $campaignCode, $adgroupCode);
		
		$ret = array(
			'clicks_cnt' => ($dailyStats ? $dailyStats['clicks_cnt'] : null),
			'downloads_cnt' => ($dailyStats ? $dailyStats['downloads_cnt'] : null),
			'network_code' => $networkCode,
			'campaign_code' => $campaignCode,
			'adgroup_code' => $adgroupCode,
			'last_update_date' => (($dailyStats AND $dailyStats['last_update_date']) ? $dailyStats['last_update_date']->format('Y-m-d H:i:s') : null),
		);
		
		$this->prepareAndSendValidResponse($ret);
	}

}