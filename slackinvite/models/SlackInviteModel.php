<?php
namespace Craft;

/**
 *
 */
class SlackInviteModel extends BaseModel
{
	/**
	 * @access protected
	 * @return array
	 */
	protected function defineAttributes()
	{
		return array(
			'name' => array('type' => AttributeType::String, 'required' => true),
			'email'=> array('type' => AttributeType::Email, 'required' => true),
		);
	}

}
