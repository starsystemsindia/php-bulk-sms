<?php
/**
 * BulkSMS PHP implementation
 *
 * @author    Andreas Lutro <anlutro@gmail.com>
 * @license   http://opensource.org/licenses/MIT
 * @package   anlutro/bulk-sms
 */

namespace anlutro\BulkSms;

class BulkSmsException extends \Exception {
    protected $code;

    public function __construct($message, $code) {
        parent::__construct($message);
        $this->code = $code;
    }

    public function getStatusCode() {
        return $this->code;
    }
}
