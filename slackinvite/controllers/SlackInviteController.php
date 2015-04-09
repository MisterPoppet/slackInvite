<?php

namespace Craft;

class SlackInviteController extends BaseController
{
	protected $allowAnonymous = true;

	public function actionSendInvite()
	{
		$this->requirePostRequest();

		$settings = craft()->plugins->getPlugin('SlackInvite')->getSettings();
		$url = 'https://'.$settings->team.'.slack.com/api/users.admin.invite';
		$data = array(
			'email' => craft()->request->getPost('email'),
			'first_name' => craft()->request->getPost('name'),
			'channels' => $settings->channels,
			'token' => $settings->token,
			'set_active' => true,
			'_attempts' => 1,
		);

		$client = new \Guzzle\Http\Client($url);
		$result = $client->post(null, [], $data)->send();
		$response = $result->json();

		if(isset($response['error']))
		{
			$error = str_replace("_", " ", $response['error']);
			craft()->userSession->setError(Craft::t($error));
		}
		else
		{
			$this->redirectToPostedUrl();
		}
	}
}