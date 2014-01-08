<?php

namespace HQ\Mail;

/*
	class for interacting with email service and database Daily Stats table
	this clase tries to read the unread emails with attachment which is CSV
	and try to read the CSV and import the data into daily_stats table

*/

class MailService extends \Nette\Object {

	private $imapDomain;
	private $imapUsername;
	private $imapPassword;
	private $mailConn;
	private $inbox;
	private $emails;
	private $emailsCount;

	/** @var \HQ\Model\Entity\DailyStatsEntity **/
	private $dailyStatsEntity;
	/** @var \HQ\Model\Entity\LogDailyStatsEntity **/
	private $logDailyStatsEntity;

	public function __construct(
		$domain, 
		$username, 
		$password, 
		\HQ\Model\Entity\DailyStatsEntity $dailyStatsEntity, 
		\HQ\Model\Entity\LogDailyStatsEntity $logDailyStatsEntity )
	{
		
		$this->imapDomain = "{" . $domain . ":993/imap/ssl}INBOX";
		$this->imapUsername = $username;
		$this->imapPassword = $password;

		$this->dailyStatsEntity = $dailyStatsEntity;
		$this->logDailyStatsEntity = $logDailyStatsEntity;
	}
	// connect imap server 
	public function connect()
	{

		$this->mailConn = \imap_open($this->imapDomain, $this->imapUsername, $this->imapPassword) or die ("Can't connect to mail server");

		if($this->mailConn) {
			// return the whole mail box
			return $this->mailConn;
		}

	}
	// close imap connection 
	public function close()
	{
		imap_close($this->mailConn);
	}
	// fetching the mailBox, 'UNSEEN' as default but use 'ALL' for reading all
	public function fetchInbox($label='UNSEEN', $sender='noreply@ad-x.co.uk')
	{
		
		$this->inbox = imap_search($this->mailConn,"$label FROM $sender"); // search the mailbox 
		$this->emailsCount = imap_num_msg($this->mailConn); // get the number of mails
		$this->emails = array();

		set_time_limit(0); // unlimited execution time

		for($i=1; $i<= $this->emailsCount; $i++){
			$headers = imap_headerinfo($this->mailConn, $i);
			//var_dump($headers);
			if($headers->Unseen == 'U'){
				$subject = $headers->subject;
				if(preg_match("/AD-X Report AD-X_Clicks/i",$subject)){
					$this->emails[] = array(
						'index' => $i, 
						'header' => imap_header($this->mailConn, $i),
						'subject' => $subject,
						'structure' => imap_fetchstructure($this->mailConn, $i),
						'uid' => $headers->message_id
					);
				}
			}
		}
		
		rsort($this->emails);

		return $this->emails;
	}
	// get attachments
	public function getAttachments($object)
	{
		// this function will retrieve the attachment object
		
		if (strtolower($object->attribute) == 'name' || strtolower($object->attribute) == 'filename') {
			$filename = pathinfo(strtolower($object->value));
			if($filename['extension'] == 'csv') {
				$attachment = array(
					'name' => $object->value,
					'filename' => $object->value,
					'attachment' => ''
				);
			}
		}
		
		return $attachment;

	}
	// check attachments
	public function checkAttachments($email)
	{
		$attachCount = 0;
		$attachments = array();

 		if(isset($email['structure']->parts) && count($email['structure']->parts)) {
 			
 			// loop through all the attachments
 			for($i=0; $i < count($email['structure']->parts);$i++) {
 				if($email['structure']->parts[$i]->ifdisposition) {
 					$parameters = array();

 					if ($email['structure']->parts[$i]->ifparameters) {
 						$parameters = $email['structure']->parts[$i]->parameters;
 					} else if ($email['structure']->parts[$i]->ifdparameters) {
 						$parameters = $email['structure']->parts[$i]->dparameters;
 					}

					foreach ($parameters as $object) {
						$attachments[$attachCount] = $this->getAttachments($object);
					}
 					
 					$attachments[$attachCount]['attachment'] = imap_fetchbody($this->mailConn, $email['index'], $i+1);
 					// check encoding is base 64
 					if ($email['structure']->parts[$i]->encoding == 3) {
 						$attachments[$attachCount]['attachment'] = base64_decode($attachments[$attachCount]['attachment']);
 					} elseif ($email['structure']->parts[$i]->encoding == 4) {
 						$attachments[$attachCount]['attachment'] = quoted_printable_decode($attachments[$attachCount]['attachment']);
 					}
 					$attachCount = $attachCount + 1;
        		}
 			}
 		}
 		
	 	return $attachments;
	}

	// this function will read CSV data 
	// and strip off the CSV heading from Adx Clicks data
	// and return only the data rows

	/*
	*
	*	Date 		date 				0
	*	Network 	network_code		1
	* 	App 		app 				2
	* 	Creative	campaign_code		3
	*	Clicks 		clicks_cnt			4
	*	Downloads	downloads_cnt		5
	*
	*/

	public function importCSV($csvData, $csvFilename, $emailCode, $emailSubject)
	{
		
		//$i=0;
		$data = str_getcsv($csvData,"\n","'","");
		unset($data[0]); // skip first row with header

		foreach($data as &$Row) {
    		
    		$linearray = str_getcsv($Row,',',''); //parse the items in rows 
    		$linemysql = implode("','",$linearray);
    			
			$adxData = array(
				"date" => new \Nette\DateTime($linearray[0]), //date("Y-m-d",strtotime($linearray[0])), //
				"network_code" => $linearray[1],
				"app" => $linearray[2],
				"campaign_code" => null,
				"adgroup_code" => $linearray[3],
				"clicks_cnt" => $linearray[4],
				"downloads_cnt" => $linearray[5],
				"ins_process_id" => 'classes.mail.mailservice:184'
			);
			
			// time to insert the data
			$this->dailyStatsEntity->insertOrUpdate($adxData);
    	}
		// log email log stats
		$emailLog = array(
			'records_count'=>count($data),
			'email_filename'=>$csvFilename,
			'email_subject' => $emailSubject,
			'email_code'=>$emailCode,
			'email_message'=> count($data) . " records has been added from " . $csvFilename
		);
		$this->logDailyStatsEntity->insertOrUpdate($emailLog);
    	return count($data);
	}
}