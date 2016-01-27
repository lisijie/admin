<?php

namespace App\Util;

class Pager extends \Core\Lib\Pager
{
	public function __construct($curPage, $pageSize, $totalNum, $route = CUR_ROUTE, $params = array())
	{
		parent::__construct($curPage, $pageSize, $totalNum, $route, $params);
		$this->setTemplates([
			'prev_page' => '<li><a href="%s">上一页</a></li>',
			'prev_page_disabled' => '<li class="disabled"><span>上一页</span></li>',
			'next_page' => '<li><a href="%s">下一页</a></li>',
			'next_page_disabled' => '<li class="disabled"><span>下一页</span></li>',
			'page_item' => '<li><a href="%s">%s</a></li>',
			'page_item_active' => '<li class="active"><span>%s</span></li>',
			'wrapper' => '<ul class="pagination">%s<li class="disabled"><span>总记录数：'.$totalNum.'</span></li></ul>', // 外层
		]);
	}
}