<?php
namespace Craft;

class SlackInvitePlugin extends BasePlugin
{
	function getName()
	{
		return 'Slack Invite';
	}

	function getVersion()
	{
		return '0.1';
	}

	function getDeveloper()
	{
		return 'Capsule DX';
	}

	function getDeveloperUrl()
	{
		return 'http://capsuledx.com';
	}

	protected function defineSettings()
	{
		return array(
			'team' => AttributeType::String,
			'token' => AttributeType::String,
			'channels' => AttributeType::String
		);
	}

	public function getSettingsHtml()
	{
		return craft()->templates->render('slackinvite/_settings', array(
			'settings' => $this->getSettings()
		));
	}
}
