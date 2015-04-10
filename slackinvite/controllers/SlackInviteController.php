<?php

namespace Craft;

/**
 * Class SlackInviteController
 *
 * @package Craft
 */
class SlackInviteController extends BaseController
{
	/**
	 * @var bool
	 */
	protected $allowAnonymous = true;

	/**
	 * @throws HttpException
	 */
	public function actionSendInvite()
	{
		$this->requirePostRequest();

		$email = craft()->request->getRequiredPost('email');
		$name = craft()->request->getRequiredPost('name');

		$model = new SlackInviteModel();
		$model->email = $email;
		$model->name = $name;

		$token = craft()->config->get('token', 'slackInvite');
		$team = craft()->config->get('team', 'slackInvite');
		$channels = craft()->config->get('channels', 'slackInvite');

		if (!$team || !$token)
		{
			throw new Exception('Missing one or more required Slack Invite plugin settings.');
		}

		if ($model->validate() && craft()->slackInvite->invite($model, $token, $team, $channels))
		{
			if (craft()->request->isAjaxRequest())
			{
				$this->returnJson(array('success' => true));
			}
			else
			{
				craft()->userSession->setFlash('slacksuccess', true);
				$this->redirectToPostedUrl();
			}
		}
		else
		{
			if (craft()->request->isAjaxRequest())
			{
				$this->returnJson(array('errors' => $model->getAllErrors()));
			}
			else
			{
				craft()->urlManager->setRouteVariables(array(
					'slack' => $model
				));
			}
		}
	}
}
