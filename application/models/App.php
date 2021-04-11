<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}

   function insert($table = '', $data = '')
   {
      return $this->db->insert($table, $data);
	}

	function get_all($table)
	{
		$this->db->from($table);

		return $this->db->get();
	}

	function get_where($table = null, $where = null)
	{
		$this->db->from($table);
		$this->db->where($where);

		return $this->db->get();
	}

	function get_like($table = null, $where = null, $like = null)
	{
		$this->db->from($table);
		$this->db->where($where);
		$this->db->like($like);

		return $this->db->get();
	}

	function select_like($table = null, $where = null, $like = null, $limit = null, $offset = null)
	{
		$this->db->from($table);
		$this->db->where($where);
		$this->db->like($like);
		$this->db->limit($limit, $offset);

		return $this->db->get();
	}
	function select_where_limit($table = null, $where = null, $limit = null, $offset = null)
	{
		$this->db->from($table);
		$this->db->where($where);
		$this->db->limit($limit, $offset);

		return $this->db->get();
	}

	function update($table = null, $data = null, $where = null)
	{
		return $this->db->update($table, $data, $where);
	}

	function delete($table = null, $where = null)
	{
		$this->db->where($where);
		$this->db->delete($table);
	}
}
