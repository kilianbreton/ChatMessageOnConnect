<?php

namespace Ankou;

use ManiaControl\Callbacks\CallbackListener;
use ManiaControl\Commands\CommandListener;
use ManiaControl\Communication\CommunicationListener;
use ManiaControl\Players\Player;
use ManiaControl\Players\PlayerManager;
use ManiaControl\Plugins\Plugin;
use ManiaControl\ManiaControl;
use ManiaControl\Settings\SettingManager;

/**
 * ChatMessageOnConnectPlugin
 *
 * @author  Ankou
 * @version 0.1
 */
class ChatMessageOnConnectPlugin implements CallbackListener, CommandListener,CommunicationListener, Plugin
{
	const ID      		= 209;
	const VERSION 		= 0.1;
	const NAME    		= 'ChatMessageOnConnect';
	const AUTHOR  		= 'Ankou';
	const DESCRIPTION 	= 'Display a message to the player when he connects to the server';

	const SETTING_MESSAGE = 'Message';

	protected $message = "";


	/** @var ManiaControl $maniaControl */
	private $maniaControl = null;



	/**
	 * @see \ManiaControl\Plugins\Plugin::load()
	 */
	public function load(ManiaControl $maniaControl)
	{
		$this->maniaControl = $maniaControl;

		$this->maniaControl->getCallbackManager()->registerCallbackListener(PlayerManager::CB_PLAYERCONNECT, $this, 'handlePlayerConnect');
		$this->maniaControl->getCallbackManager()->registerCallbackListener(SettingManager::CB_SETTING_CHANGED, $this, 'updateSettings');


		$this->maniaControl->getSettingManager()->initSetting($this, self::SETTING_MESSAGE, '$fff Welcome to the server!');
		$this->updateSettings();
	}



	public function updateSettings()
	{
		$this->message = $this->maniaControl->getSettingManager()->getSettingValue($this, self::SETTING_MESSAGE);
	}


	/**
	 * Handle PlayerConnect callback
	 *
	 * @param Player $player
	 */
	public function handlePlayerConnect(Player $player)
	{
		if (!$player)
			return;

		$this->maniaControl->getChat()->sendChat($this->message, $player->login);
	}


	/**
	 * @see \ManiaControl\Plugins\Plugin::unload()
	 */
	public function unload()
	{
		$this->maniaControl = null;
	}

	/**
	 * @see \ManiaControl\Plugins\Plugin::getId()
	 */
	public static function getId()
	{
		return self::ID;
	}

	/**
	 * @see \ManiaControl\Plugins\Plugin::getName()
	 */
	public static function getName()
	{
		return self::NAME;
	}

	/**
	 * @see \ManiaControl\Plugins\Plugin::getVersion()
	 */
	public static function getVersion()
	{
		return self::VERSION;
	}

	/**
	 * @see \ManiaControl\Plugins\Plugin::getAuthor()
	 */
	public static function getAuthor()
	{
		return self::AUTHOR;
	}

	/**
	 * @see \ManiaControl\Plugins\Plugin::getDescription()
	 */
	public static function getDescription()
	{
		return self::DESCRIPTION;
	}

	/**
	 * @see \ManiaControl\Plugins\Plugin::prepare()
	 */
	public static function prepare(ManiaControl $maniaControl)
	{

	}
}
