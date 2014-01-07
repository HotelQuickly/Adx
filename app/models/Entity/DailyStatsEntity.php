<?php

namespace HQ\Model\Entity;

class DailyStatsEntity extends BaseEntity {

	public function getStatsForCampaign($networkCode, $campaignCode) {
		return $this->getTable()
			->select('SUM(clicks_cnt) AS clicks_cnt, SUM(downloads_cnt) AS downloads_cnt')
			->where('network_code', $networkCode)
			->where('campaign_code', $campaignCode)
			->fetch();
	}
	
}