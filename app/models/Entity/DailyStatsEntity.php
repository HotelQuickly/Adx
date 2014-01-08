<?php

namespace HQ\Model\Entity;

class DailyStatsEntity extends BaseEntity {

	public function getStatsForCampaign($networkCode, $campaignCode, $adgroupCode) {
		$row = $this->getTable()
			->select('SUM(clicks_cnt) AS clicks_cnt, SUM(downloads_cnt) AS downloads_cnt, MAX(date) AS last_update_date');

		if (!empty($networkCode)) {
			$row->where('network_code', $networkCode)
		}

		if (!empty($campaignCode)) {
			$row->where('campaign_code', $campaignCode)
		}

		if (!empty($adgroupCode)) {
			$row->where('adgroup_code', $adgroupCode)
		}
			
		return $row->fetch();
	}
	
}