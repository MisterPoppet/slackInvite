# slackInvite
This is a simple Slack public invitation plugin for Craft CMS.

## Sample Form

	<div class="alert">
		{{ craft.session.getFlash( 'error', 'defaultValue' ) }}
	</div>

	<form method="post" accept-charset="UTF-8">
		<input type="hidden" name="action" value="slackInvite/sendInvite">
		<input type="hidden" name="redirect" value="{{ siteUrl }}">

		<input id="name" type="text" name="name" placeholder="Name">
		<input id="email" type="email" name="email" placeholder="Email">

		<input type="submit" value="Invite">
	</form>