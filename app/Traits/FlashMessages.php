<?php
namespace App\Traits;

/**
 * Trais messages
 * @package
 */
Trait FlashMessages {

	/**
	 *
	 * @var array
	 */
	protected $infoMessages = [];

	/**
	 *
	 * @var array
	 */
	protected $errorMessages = [];

	/**
	 *
	 * @var array
	 */
	protected $successMessages = [];

	/**
	 *
	 * @var array
	 */
	protected $warningMessages = [];


	/**
	 *
	 * @param array $message
	 * @param string $type
	 */
	protected function setFlashMessage($message, $type)
	{

		$model = 'infoMessages';

		switch($type){
			case 'info':
				$model = 'infoMessages';
				break;
			case 'error':
				$model = 'errorMessages';
			case 'success':
				$model = 'successMessages';
				break;
			case 'warning':
				$model = 'warning';
				break;
		}

		if(is_array($message)){
			foreach($message as $key => $value){
				array_push($this->$model, $value);
			}
		}
		else{
			array_push($this->$model, $message);
		}
	}

	/**
	 * *
	 * @return array
	 */
	protected function getFlashMessage()
	{
		return[
			'error' => $this->errorMessages,
			'info' => $this->infoMessages,
			'success' => $this->successMessages,
			'warning' => $this->warningMessages
		];
	}


	/**
	 *
	 * @return mixed
	 */
	protected function showFlashMessages()
	{
		session()->flash('info', $this->infoMessages);
		session()->flash('error', $this->errorMessages);
		session()->flash('success', $this->successMessages);
		session()->flash('warningMessages', $this->warningMessages);
	}
}
