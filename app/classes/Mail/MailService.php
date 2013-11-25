<?php

namespace HQ\Mail;

/*
	class for interacting with email service
*/

class MailService extends \Nette\Object {

	private $imapDomain;

	private $imapUsername;

	private $imapPassword;

	private $mailBox;

	public function __construct($domain, $username, $password)
	{
		
		$this->imapDomain = "{" . $domain . ":993/imap/ssl}INBOX";

		$this->imapUsername = $username;

		$this->imapPassword = $password;
	}

	public function connect()
	{

		$mailBox = imap_open($this->imapDomain, $this->imapUsername, $this->imapPassword) or die ("Can't connect to mail server");

		if($mailBox) {
			return $mailBox;
		}

	}

	public function close()
	{

		imap_close($this->mailBox);
	}
}