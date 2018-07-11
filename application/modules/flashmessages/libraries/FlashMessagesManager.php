<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class FlashMessagesManager implements Iterator {
	private $session_id;
	
	private $_ci;

	/**

	 * @var flashmessage[]

	 */
	protected $_msgs;

	public function __construct() {

		$this->_indexIterator = 0;

		$CI =& get_instance();
		$this->_ci = $CI;
		$this->_ci->load->model('flashmessages/flashmessage');
		$this->_ci->load->library('session');
		if ($this->_ci->session->userdata('flashmessage')) {

			$this->session_id = $this->_ci->session->userdata('flashmessage');

			$this->_msgs = $this->_ci->flashmessage->getSessionsMessages($this->session_id);
		} else {

			$this->session_id = uniqid();

			$this->_ci->session->set_userdata('flashmessage',$this->session_id);

			$this->_msgs = array();
		}
	}

	/**

	 * @param string $msg

	 * @param string $type

	 */
	public function pushNewMessage($msg, $type = null) {

		$fl = $this->_ci->flashmessage->createNewMessage($this->session_id, $msg, $type);

		$this->_msgs[] = $fl;
	}

	/**

	 * vide les messages non affichés

	 */
	public function purge() {

		$this->_ci->flashmessage->deleteSessionsFlashMessages($this->session_id);

		$this->session_id = uniqid();

		$this->_ci->session->set_userdata('flashmessage',$this->session_id);
	}

	/**

	 * @return My_Flashmessage

	 */
	public function popMessage($filterType = null) {

		if ($filterType && $this->_msgs) {

			for ($i = count($this->_msgs) - 1; $i >= 0; $i--) {

				$msg = $this->_msgs[$i];

				if ($msg->type == $filterType) {

					$fl = array_pop(array_splice($this->_msgs, $i, 1));

					$this->_ci->flashmessage->deleteId($fl->id);

					return $fl;
				}
			}
		}

		if ($this->_msgs) {

			$fl = array_pop($this->_msgs);

			$this->_ci->flashmessage->deleteId($fl->id);

			return $fl;
		}

		return false;
	}

	public function collectMessages() {

		$msgs = $this->_msgs;
		
		$this->purge();

		return $msgs;
	}

	private $_indexIterator;

	/* (non-PHPdoc)

	 * @see Iterator::current()

	 */

	public function current() {

		return $this->_msgs[$this->_indexIterator];
	}

	/* (non-PHPdoc)

	 * @see Iterator::next()

	 */

	public function next() {

		$this->_indexIterator++;
	}

	/* (non-PHPdoc)

	 * @see Iterator::key()

	 */

	public function key() {

		// TODO Auto-generated method stub

		return 'flashmessage ' . $this->_indexIterator;
	}

	/* (non-PHPdoc)

	 * @see Iterator::valid()

	 */

	public function valid() {

		// TODO Auto-generated method stub

		return $this->_indexIterator < count($this->_msgs);
	}

	/* (non-PHPdoc)

	 * @see Iterator::rewind()

	 */

	public function rewind() {

		// TODO Auto-generated method stub

		$this->_indexIterator = 0;
	}

}
