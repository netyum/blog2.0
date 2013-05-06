<?php
namespace app\widgets;

use app\widgets\Portlet;
use app\models\Comment;

class RecentComments extends Portlet
{
	public $title='Recent Comments';
	public $maxComments=10;

	public function getRecentComments()
	{
		return Comment::findRecentComments($this->maxComments);
	}

	protected function renderContent()
	{
		echo $this->render('@app/widgets/views/recentComments');
	}
}