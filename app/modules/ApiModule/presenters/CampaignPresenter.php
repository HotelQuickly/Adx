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

	/** @autowire @var \Models\DailyStats */
	protected $dailyStatsModel;

	public function actionDefault($networkCode, $campaignCode) {

		$dailyStats = $this->dailyStatsModel->getStatsForCampaign($networkCode, $campaignCode);

		$this->prepareAndSendValidResponse($dailyStats);
	}

}