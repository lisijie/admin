<?php
namespace App\Model;

use Core\Model;

class AdminModel extends Model
{

    protected $table = 'admin';

	/**
	 * 获取管理员列表
	 *
	 * @param $page
	 * @param $pageSize
	 * @param bool|false $total
	 * @return array
	 */
	public function getAdminList($page, $pageSize, &$total = false)
	{
		if ($total !== false) {
			$total = $this->count();
		}
		$result = $this->page([],[],[], $page, $pageSize);
		return $result;
	}

	// 获取管理员
	public function getAdmin($id)
	{
		return $this->getRow(array('id' => $id));
	}

	// 根据用户名获取
	public function getAdminByName($userName)
	{
		return $this->getRow(array('username' => $userName));
	}

	// 更新信息
	public function updateAdmin($id, $data = array())
	{
		return $this->update($data, array('id' => $id));
	}

	// 添加管理员
	public function addAdmin($data)
	{
		return $this->insert($data);
	}

	// 删除管理员
	public function deleteAdmin($id)
	{
		return $this->delete(array('id' => $id));
	}
}