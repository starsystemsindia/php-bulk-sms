<?php
/**
 * BulkSMS PHP implementation
 *
 * @author    Andreas Lutro <anlutro@gmail.com>
 * @license   http://opensource.org/licenses/MIT
 * @package   anlutro/bulk-sms
 */

namespace anlutro\BulkSms\Sender;

use anlutro\cURL\cURL;
use anlutro\BulkSms\Message;

/**
 * Class for sending single messages.
 */
class Single
{
	/**
	 * The URL the call should go to.
	 *
	 * @var string
	 */
	protected $url = 'http://www.bulksms.co.uk:5567/eapi/submission/send_sms/2/2.0';

	/**
	 * The cURL instance.
	 *
	 * @var anlutro\cURL\cURL
	 */
	protected $curl;

	/**
	 * The message to send.
	 *
	 * @var anlutro\BulkSms\Message
	 */
	protected $message;

	/**
	 * @param string $username BulkSMS username
	 * @param string $password BulkSMS password
	 * @param anlutro\cURL\cURL $curl  (optional) If you have an existing
	 *   instance of my cURL wrapper, you can pass it.
	 */
	public function __construct($username, $password, cURL $curl = null)
	{
		$this->username = $username;
		$this->password = $password;
		$this->curl = $curl ?: new cURL;
	}

	/**
	 * Set the message.
	 *
	 * @param anlutro\BulkSms\Message $message
	 */
	public function setMessage(Message $message)
	{
		$this->message = $message;
	}

	/**
	 * Send the message.
	 *
	 * @return mixed
	 */
	public function send()
	{
        $data = [
            'username' => $this->username,
            'password' => $this->password,
            'message' => $this->message->getMessage(),
            'msisdn' => $this->message->getRecipient(),
            'source_id' => $this->message->getSourceId(),
            'repliable' => $this->message->getRepliable()
        ];

        if (!is_null($this->message->getSender())) {
            $data['sender'] = $this->message->getSender();
        }




        $concat = $this->message->getConcatParts();

		if ($concat > 1) {
			$data['allow_concat_text_sms'] = 1;
			$data['concat_text_sms_max_parts'] = $concat;
		}

		return $this->curl->post($this->url, $data);
	}
}
