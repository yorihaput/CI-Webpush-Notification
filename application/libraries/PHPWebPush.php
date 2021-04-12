<?php 
/**
* Codeigniter Dynamic Menu Using Database
*
* @package    CodeIgniter
* @subpackage libraries
* @category   library
* @version    1.0
* @author     Yori Hadi Putra
* @link       https://github.com/yorihaput/CI-Webpush-Notification
*/

use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;
use Minishlink\WebPush\VAPID;

class PHPWebPush 
{
    /**
	* Public Key
	*
    */
    protected $publicKey;

    /**
	* Private Key
	*
    */
    protected $privateKey;

    /**
	* Contact
	*
    */
    protected $contact;

    /**
	* PHPWebPush Object
	*
    */
    protected $webpush;

    /**
	* PHPWebPush Report
	*
    */
    protected $report_status = true;
    protected $report_msg = null;

    /**
	* Constructor
	*
	* @access	public
	*
    */

    public function __construct()
    {
        $this->_ci = & get_instance();
		$this->_ci->load->config('webpush_config');

        $this->privateKey = $this->_ci->config->item('privatekey', 'webpush');
        $this->publicKey = $this->_ci->config->item('publickey', 'webpush');
        $this->contact = $this->_ci->config->item('contact', 'webpush');

        if(!empty($this->publicKey) && !empty($this->publicKey) && !empty($this->contact)) {
            $auth = [
                'VAPID' => [
                    'subject' => 'mailto:'.$this->contact,
                    'publicKey' => $this->publicKey,
                    'privateKey' => $this->privateKey,
                ],
            ];
        }

        if(!empty($auth)) {
            $this->webpush = new WebPush($auth);
        }else{
            $this->webpush = new WebPush();
        }
    }

    // --------------------------------------------------------------------

    /**
    * Send notification
    *
    * @access	public
    * @param	array $client
    * @param	string $notif
	* @param	bool $single
    * @return	array
    */

    public function send($client, $notif, $single = true){
        if($single === false) {
            foreach ($client as $row) {
                $this->webpush->queueNotification(Subscription::create($row),$notif);
            }

            foreach ($this->webpush->flush() as $report) {
                if($this->report_status) {
                    $endpoint = $report->getRequest()->getUri()->__toString();
                    if ($report->isSuccess() == false) {
                        $this->report_msg = "[x] Message failed to sent for subscription {$endpoint}: {$report->getReason()}";
                        $this->report_status = false;
                    }
                }
            }
        }else{
            $report = $this->webpush->sendOneNotification(Subscription::create($client), $notif);
            $endpoint = $report->getRequest()->getUri()->__toString();
            if ($report->isSuccess() == false) {
                $this->report_msg = "[x] Message failed to sent for subscription {$endpoint}: {$report->getReason()}";
                $this->report_status = false;
            }
        }

        return ['status' => $this->report_status, 'message' => $this->report_msg];
    }

    // --------------------------------------------------------------------


    /**
    * Generate Public Key & Private Key need OpenSSL to generate
    *
    * @access	public
    * @return	array
    */

    public function generate_key()
    {
        return VAPID::createVapidKeys();
    }

    // --------------------------------------------------------------------
}

?>