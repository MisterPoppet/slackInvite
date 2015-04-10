<?php

namespace Craft;

/**
 * Class SlackInviteService
 *
 * @package Craft
 */
class SlackInviteService extends BaseApplicationComponent
{
	/**
	 * Invites a user to the given Slack team.
	 *
	 * @param SlackInviteModel $model    The model with email and name information.
	 * @param string           $token    The Slack web API token.
	 * @param string           $team     The Slack team handle.
	 * @param string|null      $channels Optional channels to default the user to.
	 *
	 * @return bool
	 */
	public function invite(SlackInviteModel $model, $token, $team, $channels = null)
	{
		$data = array(
			'email' => $model->email,
			'first_name' => $model->name,
			'channels' => $channels,
			'token' => $token,
			'set_active' => true,
			'_attempts' => 1,
		);

		$client = new \Guzzle\Http\Client();

		$options = array(
			'timeout'         => 30,
			'connect_timeout' => 2,
			'allow_redirects' => false,
		);

		$url = 'https://'.$team.'.slack.com/api/users.admin.invite';

		$request = $client->post($url, $options, $data);

		try
		{
			$response = $request->send();

			if ($response->isSuccessful())
			{
				$response = $response->json();

				if (isset($response['error']))
				{
					SlackInvitePlugin::log('There was a problem inviting a Slack user. Code: '.$response['error'], LogLevel::Error);

					if (in_array($response['error'], array('sent_recently', 'already_invited', 'already_in_team')))
					{
						// Just fake it
						return true;
					}
					else
					{
						return false;
					}
				}
				else
				{
					SlackInvitePlugin::log('Successfully invited user: '.$model->email.' to Slack.', LogLevel::Info);
					return true;
				}
			}
			else
			{
				SlackInvitePlugin::log('There was a problem connecting to Slack: '.$response->getBody(true), LogLevel::Error);
			}
		}
		catch (\Exception $e)
		{
			SlackInvitePlugin::log('There was a problem connecting to Slack: '.$e->getMessage(), LogLevel::Error);
		}

		return false;
	}
}
