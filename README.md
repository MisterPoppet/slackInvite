# slackInvite
This is a simple Slack public invitation plugin for Craft CMS.

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
