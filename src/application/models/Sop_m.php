<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Sop_m extends CI_Model
    {
		
		function select_table($table,$field)
		{
			$q = $this->db->query("SELECT * FROM $table order by $field");
			return $q;
		}
		function edit_table($table,$field,$id)
		{
			$q = $this->db->query("SELECT * FROM $table where $field='$id'");
			return $q;
		}
		function query_manual_select($datainput)
		{
			$q = $this->db->query($datainput);
			return $q;
		}
		
		function query_manual($datainput)
		{
			$q = $this->db->query($datainput);
			return $q;
		}
		
		function get_datatables($Function)
		{
			$this->$Function();
			if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
			$query = $this->db->get();
			return $query->result();
		}
		public function count_all($Table)
		{
			$this->db->from($Table);
			return $this->db->count_all_results();
		}
		function count_filtered($Function)
		{
			$this->$Function();
			$query = $this->db->get();
			return $query->num_rows();
		}
		public function cek_null($Table,$Coloum,$Where)
		{
			$this->db->from($Table);
			$this->db->where($Coloum, $this->db->escape_like_str($Where));
			return $this->db->count_all_results();
		}
		public function nourut($unitkerjaid)
		{
			$data=0;
			$q = $this->db->query("select sop_nourut from vwsop where unit_kerja_id='".$this->db->escape_like_str($unitkerjaid)."' order by sop_nourut desc limit 1");
			foreach ($q->result_array() as $row)
			{
				$data = $row['sop_nourut'];
			}
			return $data;
		}
		
		
		
		
		
		
		function field_sop($tabel,$field,$where,$alias)
		{
			$data = '';
			$this->db->select($field);
			$this->db->from($tabel);
			$this->db->where($where, $this->db->escape_like_str($alias));
			$query = $this->db->get();
			foreach ($query->result_array() as $row)
			{
				$data = $row;
			}
			$query->free_result();
			return $data;
		}
		function img_simbol($nama)
		{
			$data = array();
			$this->db->select('simbol_img,simbol_margin');
			$this->db->from('simbol');
			$this->db->where('simbol_nama', $this->db->escape_like_str($nama));
			$query = $this->db->get();
			foreach ($query->result_array() as $row)
			{
				$data[] = $row;
			}
			$query->free_result();
			return $data;
		}
		public function jabatan($satkerid,$unitkerjaid){
			$this->db->where('satuan_organisasi_id', $this->db->escape_like_str($satkerid));
			$this->db->where('unit_kerja_id', $this->db->escape_like_str($unitkerjaid));
			$this->db->limit(1);
			return $this->db->get('ttd_pengesah');

			//$q = $this->db->query("select * from ttd_pengesah where satuan_organisasi_id='".$this->db->escape_like_str($satkerid)."' and unit_kerja_id='".$this->db->escape_like_str($unitkerjaid)."' limit 1");
			//return $q;
		}
		function kat_sop()
		{
			$q = $this->db->query("select * from kategori_sop order by kategori_id");
			return $q;
		}
		function alias_sop1()
		{
			$data = array();
			$q = $this->db->query("SELECT FLOOR(RAND() * 9999999999) AS random_num FROM sop  WHERE 'random_num' NOT IN (SELECT sop_alias FROM sop) LIMIT 1");
			foreach ($q->result_array() as $row)
			{
				$data[] = $row;
			}
			return $data;
		}
		function revisi_alias($alias)
		{
			$data = '';
			$this->db->select('*');
			$this->db->from('revisi');
			$this->db->where('sop_alias', $this->db->escape_like_str($alias));
			//$this->db->where('sop_revisi_alias', '');
			$query = $this->db->get();
			foreach ($query->result_array() as $row)
			{
				$data = $row;
			}
			$query->free_result();
			return $data;
		}
		function get_jabatan($satkerid,$unitkerjaid)
		{
			$data = '';
			$this->db->select('user_id');
			$this->db->from('ttd_pengesah');
			$this->db->where('satuan_organisasi_id', $this->db->escape_like_str($satkerid));
			$this->db->where('unit_kerja_id', $this->db->escape_like_str($unitkerjaid));
			$query = $this->db->get();
			foreach ($query->result_array() as $row)
			{
				$data = $row;
			}
			$query->free_result();
			return $data;
		}
		function alias_sop2()
		{
			$data = array();
			$q = $this->db->query("SELECT FLOOR(RAND() * 9999999999) AS random_num LIMIT 1");
			foreach ($q->result_array() as $row)
			{
				$data[] = $row;
			}
			return $data;
		}
		function cek_jml_sop()
		{
			$q = $this->db->query("select count(sop_id) as jml from vwsop");
			foreach ($q->result_array() as $row)
			{
				$data = $row['jml'];
			}
			return $data;
		}
		function sop_detail($alias)
		{
			$q = $this->db->query("select k.kategori_nama, s.*, su.sop_update_file from sop s left join kategori_sop k on s.kategori_id=k.kategori_id left join sop_update su on su.sop_alias=s.sop_alias where s.sop_alias='".$this->db->escape_like_str($alias)."'");
			return $q;
		}
		function sop_revisi_detail($alias)
		{
			$q = $this->db->query("select k.kategori_nama, s.*, su.sop_update_file from sop_revisi s left join kategori_sop k on s.kategori_id=k.kategori_id left join sop_update su on su.sop_alias=s.sop_alias where s.sop_revisi_alias='".$this->db->escape_like_str($alias)."'");
			return $q;
		}
		function revisi_detail($alias,$id)
		{
			$q = $this->db->query("select * from revisi where sop_alias='".$this->db->escape_like_str($alias)."' and revisi_id='".$this->db->escape_like_str($id)."'");
			return $q;
		}
		function reviu_detail($alias,$id)
		{
			$q = $this->db->query("select * from reviu where sop_alias='".$this->db->escape_like_str($alias)."' and reviu_id='".$this->db->escape_like_str($id)."'");
			return $q;
		}
		function ttd_pengesah($userid)
		{
			$q = $this->db->query("select * from ttd_pengesah where ttd_pengesah_status='Y' and user_id=".$this->db->escape_like_str($userid)." limit 1");
			return $q;
		}
		/* ================================================================================================================================================================ */
		function datasopfront()
		{
			$table = '(select a.*,u.unit_kerja_nama from vwsop a left join unit_kerja u on a.unit_kerja_id=u.unit_kerja_id where a.sop_tgl_efektif !="") as vwsop';
			$column = array('sop_alias','sop_no','sop_nama','sop_tgl_pembuatan','sop_status','unit_kerja_nama');
			$order = array('sop_id' => 'asc');
			
			$this->db->from($table);
			$i = 0;
			foreach ($column as $item) 
			{
				if(isset($_POST['search']['value'])){
					($i===0) ? $this->db->like($item, $this->db->escape_like_str($_POST['search']['value'])) : $this->db->or_like($item, $this->db->escape_like_str($_POST['search']['value']));
				}
				$column[$i] = $item;
				$i++;
			}
			
			if(isset($_POST['order']))
			{
				$this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
			} 
			else if(isset($order))
			{
				$order = $order;
				$this->db->order_by(key($order), $order[key($order)]);
			}
		}
		/* ================================================================================================================================================================ */
			
		/* ================================================================================================================================================================ */
		function dataevaluasifront()
		{
			$table = 'vwevaluasi';
			$column = array('sop_alias','sop_no','sop_nama','sop_tgl_pembuatan');
			$order = array('sop_alias' => 'asc');
			
			$this->db->from($table);
			$i = 0;
			foreach ($column as $item) 
			{
				if(isset($_POST['search']['value'])){
					($i===0) ? $this->db->like($item, $this->db->escape_like_str($_POST['search']['value'])) : $this->db->or_like($item, $this->db->escape_like_str($_POST['search']['value']));
				}
				$column[$i] = $item;
				$i++;
			}
			
			if(isset($_POST['order']))
			{
				$this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
			} 
			else if(isset($order))
			{
				$order = $order;
				$this->db->order_by(key($order), $order[key($order)]);
			}
		}
		/* ================================================================================================================================================================ */
			
		/* ================================================================================================================================================================ */
		function datasop()
		{
			$session_data = $this->session->userdata;
			$groupid = $session_data['groupid'];
			$userid = $session_data['userid'];
			$unitkerjaid = $session_data['unitkerjaid'];
			
			$where = ($groupid == 9 ? 'where a.user_id='.$userid.'' : ($groupid == 10 ? 'where a.unit_kerja_id='.$unitkerjaid.'' : ''));
			$table = '(select a.*,z.user_fullname as penyusun from vwsop a inner join user z on a.user_id=z.user_id '.$where.') as vwsop';
			$column = array('sop_alias','sop_no','sop_nama','sop_tgl_pembuatan','sop_status','sop_step','kategori_nama','penyusun');
			$order = array('sop_id' => 'desc');
			
			$this->db->from($table);
			$i = 0;
			foreach ($column as $item) 
			{
				if(isset($_POST['search']['value'])){
					($i===0) ? $this->db->like($item, $this->db->escape_like_str($_POST['search']['value'])) : $this->db->or_like($item, $this->db->escape_like_str($_POST['search']['value']));
				}
				$column[$i] = $item;
				$i++;
			}
			
			if(isset($_POST['order']))
			{
				$this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
			} 
			else if(isset($order))
			{
				$order = $order;
				$this->db->order_by(key($order), $order[key($order)]);
			}
		}
		/* ================================================================================================================================================================ */
			
		/* ================================================================================================================================================================ */
		function lapsop()
		{
			$where ="";
			if($_POST['satuan_organisasi'] != '') $where .=" and satuan_organisasi_id='".$_POST['satuan_organisasi']."'";
			if($_POST['unitkerja'] != '') $where .=" and unit_kerja_id='".$_POST['unitkerja']."'";
			if($_POST['bagian'] != '') $where .=" and bagian_id='".$_POST['bagian']."'";
		
			$table = '(select * from vwsop  where 1=1 '.$where.') as vwsop';
			$column = array('sop_alias','sop_no','sop_nama','sop_tgl_pembuatan','sop_status','sop_step','kategori_nama');
			$order = array('sop_id' => 'desc');
			
			$this->db->from($table);
			$i = 0;
			foreach ($column as $item) 
			{
				if(isset($_POST['search']['value'])){
					($i===0) ? $this->db->like($item, $this->db->escape_like_str($_POST['search']['value'])) : $this->db->or_like($item, $this->db->escape_like_str($_POST['search']['value']));
				}
				$column[$i] = $item;
				$i++;
			}
			
			if(isset($_POST['order']))
			{
				$this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
			} 
			else if(isset($order))
			{
				$order = $order;
				$this->db->order_by(key($order), $order[key($order)]);
			}
		}
		/* ================================================================================================================================================================ */
			
		/* ================================================================================================================================================================ */
		function pilihsop()
		{
			$table = '(select * from sop where sop_alias not in (select sop_alias from evaluasi_detail) and sop_status="DISAHKAN" group by sop_alias) as vwsop';
			$column = array('sop_alias','sop_no','sop_nama');
			$order = array('sop_id' => 'asc');
			
			$this->db->from($table);
			$i = 0;
			foreach ($column as $item) 
			{
				if(isset($_POST['search']['value'])){
					($i===0) ? $this->db->like($item, $this->db->escape_like_str($_POST['search']['value'])) : $this->db->or_like($item, $this->db->escape_like_str($_POST['search']['value']));
				}
				$column[$i] = $item;
				$i++;
			}
			
			if(isset($_POST['order']))
			{
				$this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
			} 
			else if(isset($order))
			{
				$order = $order;
				$this->db->order_by(key($order), $order[key($order)]);
			}
		}
		/* ================================================================================================================================================================ */
			
		/* ================================================================================================================================================================ */
		function uploadsop()
		{
			$table = 'berkas_sop';
			$column = array('sop_alias','sop_nama','tanggal');
			$order = array('id' => 'desc');
			
			$this->db->from($table);
			$i = 0;
			foreach ($column as $item) 
			{
				if(isset($_POST['search']['value'])){
					($i===0) ? $this->db->like($item, $this->db->escape_like_str($_POST['search']['value'])) : $this->db->or_like($item, $this->db->escape_like_str($_POST['search']['value']));
				}
				$column[$i] = $item;
				$i++;
			}
			
			if(isset($_POST['order']))
			{
				$this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
			} 
			else if(isset($order))
			{
				$order = $order;
				$this->db->order_by(key($order), $order[key($order)]);
			}
		}
		/* ================================================================================================================================================================ */
			
		/* ================================================================================================================================================================ */
		function revisisop()
		{
			$session_data = $this->session->userdata;
			$groupid = $session_data['groupid'];
			$userid = $session_data['userid'];
			$unitkerjaid = $session_data['unitkerjaid'];
			
			$where = ($groupid == 9 ? 'where user_id='.$userid.'' : ($groupid == 10 ? 'where unit_kerja_id='.$unitkerjaid.'' : ''));
			$table = '(select * from vwrevisi '.$where.') as vwrevisi';
			$column = array('sop_alias','sop_no','sop_nama','revisi_tanggal','revisi_status','revisi_selesai');
			$order = array('revisi_id' => 'asc');
			
			$this->db->from($table);
			$i = 0;
			foreach ($column as $item) 
			{
				if(isset($_POST['search']['value'])){
					($i===0) ? $this->db->like($item, $this->db->escape_like_str($_POST['search']['value'])) : $this->db->or_like($item, $this->db->escape_like_str($_POST['search']['value']));
				}
				$column[$i] = $item;
				$i++;
			}
			
			if(isset($_POST['order']))
			{
				$this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
			} 
			else if(isset($order))
			{
				$order = $order;
				$this->db->order_by(key($order), $order[key($order)]);
			}
		}
		/* ================================================================================================================================================================ */
			
		/* ================================================================================================================================================================ */
		function pengesahsop()
		{
			$session_data = $this->session->userdata;
			$groupid = $session_data['groupid'];
			$userid = $session_data['userid'];
			$unitkerjaid = $session_data['unitkerjaid'];
			
			$where = ($groupid == 9 ? 'and user_id='.$userid.'' : ($groupid == 10 ? 'and unit_kerja_id='.$unitkerjaid.'' : ''));
			$table = '(select * from vwsop where sop_step="pengesah" and sop_status!="DISAHKAN" '.$where.') as vwsop';
			$column = array('sop_alias','sop_no','sop_nama','sop_tgl_pembuatan','sop_status','sop_step','kategori_nama');
			$order = array('sop_id' => 'asc');
			
			$this->db->from($table);
			$i = 0;
			foreach ($column as $item) 
			{
				if(isset($_POST['search']['value'])){
					($i===0) ? $this->db->like($item, $this->db->escape_like_str($_POST['search']['value'])) : $this->db->or_like($item, $this->db->escape_like_str($_POST['search']['value']));
				}
				$column[$i] = $item;
				$i++;
			}
			
			if(isset($_POST['order']))
			{
				$this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
			} 
			else if(isset($order))
			{
				$order = $order;
				$this->db->order_by(key($order), $order[key($order)]);
			}
		}
		/* ================================================================================================================================================================ */
			
		/* ================================================================================================================================================================ */
		function evaluasisop()
		{	
			$table = '(select b.evaluasi_id,a.sop_no,a.sop_tgl_pembuatan,a.sop_nama,a.sop_alias from (select sop_no,sop_tgl_pembuatan,sop_nama,sop_alias from sop group by sop_alias) a inner join evaluasi_detail b on a.sop_alias=b.sop_alias) as evaluasi';
			$column = array('evaluasi_id','sop_no','sop_nama');
			$order = array('evaluasi_id' => 'asc');
			
			$this->db->from($table);
			$i = 0;
			foreach ($column as $item) 
			{
				if(isset($_POST['search']['value'])){
					($i===0) ? $this->db->like($item, $this->db->escape_like_str($_POST['search']['value'])) : $this->db->or_like($item, $this->db->escape_like_str($_POST['search']['value']));
				}
				$column[$i] = $item;
				$i++;
			}
			
			if(isset($_POST['order']))
			{
				$this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
			} 
			else if(isset($order))
			{
				$order = $order;
				$this->db->order_by(key($order), $order[key($order)]);
			}
		}
		/* ================================================================================================================================================================ */
			
		
		function cek_notif($id)
		{
			$data = '';
			$this->db->select('notif_action');
			$this->db->from('notif');
			$this->db->where('notif_id', $this->db->escape_like_str($id));
			$query = $this->db->get();
			foreach ($query->result_array() as $row)
			{
				$data = $row;
			}
			$query->free_result();
			return $data;
		}
		
		
		
		
		
	
	 
	
		
}