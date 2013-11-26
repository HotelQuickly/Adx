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

		if(count($emails)){
			foreach ($emails as $email) {
				
				$attachments = $this->mailService->checkAttachments($email);
				
				if(count($attachments)){

					foreach ($attachments as $attachment) {
						$totalRecord = $this->mailService->importCSV($attachment['attachment'],$attachment['filename'],$email['uid'],$email['subject']);
						echo $totalRecord . " records has been added from " . $attachment['filename'] . "<br />";
					}
				}else{
					echo "No attachment to import";
				}
			}
		}else{
			echo "No new emails with attachment to do processing!";
		}
	}
}