<?php

namespace CronModule;

/**
 * Description of Homepage
 *
 */
class MailPresenter extends BasePresenter {

	/** @autowire @var \HQ\Mail\MailService **/
	protected $mailService;

	public function renderDefault() {
		$stop();
	}

	public function actionCheckMail()
	{
		
		$mailConn = $this->mailService->connect();
		$emails = $this->mailService->fetchInbox();

		$attachments = $this->mailService->checkAttachments($emails);
		
		foreach ($attachments as $attachment) {
			$totalRecord = $this->mailService->readCSV($attachment['attachment']);
			echo $totalRecord . " has been added. <br />";
		}
		
	}
}