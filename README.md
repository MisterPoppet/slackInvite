# slackInvite
This is a simple Slack public invitation plugin for Craft CMS.

## How to configure
To make this plugin work, you need to fill in the three values in the `config.php` file.

`team` is the subdomain slug for your Slack team. So in the URL `http://example.slack.com`, it's `example`.

`token` is an API Token for an admin user. You can generate one [here](https://api.slack.com/web#authentication).

`channels` are a comma-separated list of channel IDs. You can get those IDs by going to [this page](https://api.slack.com/methods/channels.list/test) and pressing the **Test Method** button. It'll display a nice list of your channels.

## Sample Form

	{% set success = craft.session.getFlash('slacksuccess', false) %}

	{% if success or craft.request.getQuery('success') %}
		<p>Signed up!</p>
	{% else %}
		<form method="post" accept-charset="UTF-8">

			{{ getCsrfInput() }}

			<input type="hidden" name="action" value="slackInvite/sendInvite">

			<div>
				<input type="text" name="name" value="{{ slack is defined ? slack.name }}" placeholder="Name">
				<input type="email" name="email" value="{{ slack is defined ? slack.email }}" placeholder="Email">

				<input class="submit" type="submit" value="Request an invite">

			</div>

			{% if slack is defined and slack.hasErrors() %}
				<div>
					<p>{{ slack.getAllErrors()|join('<br>')|raw }}</p>
				</div>
			{% endif %}
		</form>
	{% endif %}
