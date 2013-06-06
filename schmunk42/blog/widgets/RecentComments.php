<?php
namespace schmunk42\blog\widgets;

use schmunk42\blog\widgets\Portlet;
use schmunk42\blog\models\Comment;

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
		echo $this->render('recentComments');
	}
}