<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Batch_mails_model extends CI_Model {
	var $id = - 1;
	var $subject = '';
	var $emailText = '';
	var $recipientCount = 0;
	var $sentDate = NULL;
	var $senderID = - 1;

	public function __construct() {
		parent::__construct ();
	}

	public function insert($subject, $emailText, $recipientCount, $senderEmail) {
		$dbRes = $this->db->get_where ( 'users', array (
				'email' => $senderEmail
		) );

		$row = $dbRes->row_array ();
		$senderID = $row ['userid'];

		$insertdata = array (
				'recipientCount' => $recipientCount,
				'subject' => $subject,
				'emailText' => $emailText,
				'sentDate' => date ( 'Y-m-d' ),
				'senderID' => $senderID
		);

		if (! $this->db->insert ( 'batch_mails', $insertdata )) {
			log_message ( 'error', "Insert failed when creating batch mail record." );
			return FALSE;
		}

		syslog ( LOG_INFO, 'Successfully created batch email record' );
		return TRUE;
	}
}
