<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) PHP-Fusion Inc
| https://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: AMTP2GOMailer.php
| Author: Douwe Yntema
| Copyright 2021 hulpteugel.nl
+--------------------------------------------------------+
| This integrates the sending via AMTP2GO API into
| PHP-Fusion.
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/

namespace smtp2gomail;

require 'MimetypeHelper.php';

class SMTP2GOMailer {

	protected $apiUrl='https://api.smtp2go.com/v3/';
	protected $domain;
	protected $apiKey;
	

	protected $subject;
	protected $htmlmessage;
    protected $plainmessage;
	protected $to;
    protected $cc;
    protected $bcc;
    protected $attachments;
	protected $from;
	protected $sent = false;

	public function __construct($domain, $apiKey){

		$this->domain=$domain;
		$this->apiKey=$apiKey;


	}



	public function mail($subject, $htmlmessage, $plainmessage="") {

		$this->subject = $subject;
        $this->htmlmessage = $htmlmessage;
	    $this->plainmessage = $plainmessage;

		return $this;

	}

	public function to($arrayOrString) {

		if (is_string($arrayOrString)) {
			$this->to = array(
			    0 => $arrayOrString
            );
		} elseif (is_array($arrayOrString)) {
            $this->to = $arrayOrString;

		} else {
			throw new Exception('Expected array or string to($email)');
		}

		return $this;
	}

    public function cc($arrayOrString) {

        if (is_string($arrayOrString)) {
            $this->cc = array(
                0 => $arrayOrString
            );
        } elseif (is_array($arrayOrString)) {
            $this->cc = $arrayOrString;

        } else {
            throw new Exception('Expected array or string cc($email)');
        }

        return $this;
    }

    public function bcc($arrayOrString) {

        if (is_string($arrayOrString)) {
            $this->bcc = array(
                0 => $arrayOrString
            );
        } elseif (is_array($arrayOrString)) {
            $this->bcc = $arrayOrString;

        } else {
            throw new Exception('Expected array or string bcc($email)');
        }

        return $this;
    }

	public function from($address, $name = null) {

        $this->from = $name ? $name." <".$address.">" : $address;
		return $this;
	}

	public function send() {

		if ($this->sent) {
			throw new \Exception('Already sent');
		}

		$result=$this->_request($this->apiUrl.'/email/send', array(
		    'api_key'=>$this->apiKey,
            'sender'=>$this->from,
			'to'=>$this->to,
			'cc'=>$this->cc,
            'bcc'=>$this->bcc,
			'subject'=>$this->subject,
			'html_body'=>$this->htmlmessage,
            'text_body' => $this->plainmessage,
            'attachments' =>$this->attachments

		));

		$json=json_decode($result);


		if(empty($json)){
			throw new \Exception($result);
		}

		return $result;

	}



    public function Attachments($add_attachments)
    {
        $helper = new MimetypeHelper;

        $this->attachments = array();

        if (is_string($add_attachments)) {
            $this->attachments[0] = array(
                'filename' => basename($add_attachments),
                'fileblob' => base64_encode(file_get_contents($add_attachments)),
                'mimetype' => $helper->getMimeType($add_attachments),
            );

        }    elseif (is_array($add_attachments)) {
            foreach ((array) $add_attachments as $path) {
                $this->attachments[] = array(
                    'filename' => basename($path),
                    'fileblob' => base64_encode(file_get_contents($path)),
                    'mimetype' => $helper->getMimeType($path),
                );
            }

            } else {
             throw new Exception('Expected array or string attachment($add_attachments)');
        }
        return $this;
    }


	protected function _request($url, $fields=array()){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);

		if(count($fields)){
			curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "Content-Type: application/json"
            ));
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
		}
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$result = curl_exec($ch);

		curl_close($ch);

		return $result;

	}


}