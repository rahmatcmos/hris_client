<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory extends MX_Controller {

  public $data;

    function __construct()
    {
        parent::__construct();
        $this->load->library('authentication', NULL, 'ion_auth');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->load->database();
        $this->load->model('auth/auth_model','auth_model');
        $this->lang->load('auth');
        $this->load->helper('language');
        
    }

    function index($fname = "fn:",$sort_by = "id", $sort_order = "asc", $offset = 0)
    {

        if (!$this->ion_auth->logged_in())
        {
            //redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        elseif (!is_admin_inventaris()) //remove this elseif if you want to enable this for non-admins
        {
            $id = $this->session->userdata('user_id');
            //redirect them to the home page because they must be an administrator to view this
            //return show_error('You must be an administrator to view this page.');
            redirect('person/detail/'.$id);
        }
        else
        {
            //set the flash data error message if there is one
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            //set sort order
            $this->data['sort_order'] = $sort_order;
            
            //set sort by
            $this->data['sort_by'] = $sort_by;
           
            //set filter by first name
            $this->data['fname_param'] = $fname; 
            $exp_fname = explode(":",$fname);
            $fname_re = str_replace("_", " ", $exp_fname[1]);
            $fname_post = (strlen($fname_re) > 0) ? array('users.username'=>$fname_re) : array() ;
            
            
            //set default limit in var $config['list_limit'] at application/config/ion_auth.php 
            $this->data['limit'] = $limit = 10;//(strlen($this->input->post('limit')) > 0) ? $this->input->post('limit') : $this->config->item('list_limit', 'ion_auth') ;

            $this->data['offset'] = 6;

            //list of filterize all users  
            $this->data['users_all'] = $this->ion_auth->like($fname_post)->where('id !=', 1)->users()->result();
            
            //num rows of filterize all users
            $this->data['num_rows_all'] = $this->ion_auth->like($fname_post)->where('id !=', 1)->users()->num_rows();

            //list of filterize limit users for pagination  
            $this->data['users'] = $this->ion_auth->like($fname_post)->limit($limit)->offset($offset)->order_by($sort_by, $sort_order)->where('id !=', 1)->users()->result();

            $this->data['users_num_rows'] = $this->ion_auth->like($fname_post)->limit($limit)->offset($offset)->order_by($sort_by, $sort_order)->where('id !=', 1)->users()->num_rows();

             //config pagination
             $config['base_url'] = base_url().'inventory/index/fn:'.$exp_fname[1].'/'.$sort_by.'/'.$sort_order.'/';
             $config['total_rows'] = $this->data['num_rows_all'];
             $config['per_page'] = $limit;
             $config['uri_segment'] = 6;

            //inisialisasi config
             $this->pagination->initialize($config);
             
             if(is_admin_it()){
                $this->data['type'] = $type = 'it';
            }elseif(is_admin_hrd()){
                $this->data['type'] = $type = 'hrd';
            }elseif(is_admin_logistik()){
                $this->data['type'] = $type = 'logistik';
            }elseif(is_admin_perpus()){
                $this->data['type'] = $type = 'perpus';
            }elseif(is_admin_koperasi()){
                $this->data['type'] = $type = 'koperasi';
            }elseif(is_admin_keuangan()){
                $this->data['type'] = $type = 'keuangan';
            }else{
                $this->data['type'] = $type = '';
            }

             //$this->data['is_submit'] = getValue('is_submit_'.$type,'users_exit');

            //create pagination
            $this->data['halaman'] = $this->pagination->create_links();

            $this->data['fname_search'] = array(
                'name'  => 'first_name',
                'id'    => 'first_name',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('first_name'),
            );
            $this->_render_page('inventory/index', $this->data);
        }
    }

    function keywords(){
        if (!$this->ion_auth->logged_in())
        {
            //redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        else
        {
            $fname_post = (strlen($this->input->post('first_name')) > 0) ? strtolower(url_title($this->input->post('first_name'),'_')) : "" ;

            redirect('inventory/index/fn:'.$fname_post, 'refresh');
        }
    }

    function detail($user_id)
    {  
        $this->data['title'] = 'Inventaris Karyawan';
        $this->data['sess_nik'] = $sess_nik = get_nik($this->session->userdata('user_id'));
        $superior_it = getValue('user_app_lv1_it', 'users_exit', array('user_id'=>'where/'.$user_id));
        $superior_hrd = getValue('user_app_lv1_hrd', 'users_exit', array('user_id'=>'where/'.$user_id));
        $superior_logistik = getValue('user_app_lv1_logistik', 'users_exit', array('user_id'=>'where/'.$user_id));
        $superior_koperasi = getValue('user_app_lv1_koperasi', 'users_exit', array('user_id'=>'where/'.$user_id));
        $superior_perpus = getValue('user_app_lv1_perpus', 'users_exit', array('user_id'=>'where/'.$user_id));
        $superior_keuangan = getValue('user_app_lv1_keuangan', 'users_exit', array('user_id'=>'where/'.$user_id));

        if (!$this->ion_auth->logged_in())
        {
            $this->session->set_userdata('last_link', $this->uri->uri_string());
            redirect('auth/login', 'refresh');
        
        }elseif(is_admin_inventaris() || $sess_nik==$superior_hrd || $sess_nik==$superior_it || $sess_nik==$superior_logistik || $sess_nik==$superior_koperasi || $sess_nik==$superior_perpus){
          //  die($sess_nik.'=='.$superior_it);
            if(is_admin_it() || $sess_nik===$superior_it){
                $group_id = 2;
                $type = 'it';
            }elseif(is_admin_hrd() ||$sess_nik===$superior_hrd){
                $group_id = 1;
                $type = 'hrd';
            }elseif(is_admin_logistik() || $sess_nik===$superior_logistik){
                $group_id = 3;
                $type = 'logistik';
            }elseif(is_admin_perpus() || $sess_nik===$superior_perpus){
                $group_id = 5;
                $type = 'perpus';
            }elseif(is_admin_koperasi() || $sess_nik===$superior_koperasi){
                $group_id = 4;
                $type = 'koperasi';
            }elseif(is_admin_keuangan() || $sess_nik===$superior_keuangan){
                $group_id = 6;
                $type = 'keuangan';
            }else{
                $group_id = 0;
            }

            $num_rows = getAll('users_exit', array('user_id'=>'where/'.$user_id))->num_rows();
            $num_rows_exit = getAll('users_exit')->num_rows();
            if($num_rows>0){
               $exit_id = getValue('id', 'users_exit', array('user_id'=>'where/'.$user_id));
               $this->data['is_submit'] = getValue('is_submit_'.$type,'users_exit', array('id'=>'where/'.$exit_id));
               $this->data['user_submit'] = getValue('user_submit_'.$type,'users_exit', array('id'=>'where/'.$exit_id));
               $this->data['date_submit'] = getValue('date_submit_'.$type,'users_exit', array('id'=>'where/'.$exit_id));
               $this->data['user_edit'] = getValue('user_edit_'.$type,'users_exit', array('id'=>'where/'.$exit_id));
               $this->data['date_edit'] = getValue('date_edit_'.$type,'users_exit', array('id'=>'where/'.$exit_id));
               $this->data['is_app_lv1'] = getValue('is_app_lv1_'.$type,'users_exit', array('id'=>'where/'.$exit_id));
               $this->data['user_app_lv1'] = getValue('user_app_lv1_'.$type,'users_exit', array('id'=>'where/'.$exit_id));
               $this->data['date_app_lv1'] = getValue('date_app_lv1_'.$type,'users_exit', array('id'=>'where/'.$exit_id));
               $this->data['exit_id']  = getValue('id', 'users_exit', array('user_id'=>'where/'.$user_id));
            }else{
                $exit_id = $this->db->select('id')->order_by('id', 'asc')->get('users_exit')->last_row();
                $this->data['exit_id']  = ($num_rows_exit>0)?$exit_id->id+1:1;
                $this->data['is_submit'] = 0;
            }
            $this->db->insert_id();
            $q = $this->db->get('users_exit');
            
            $this->data['user_id'] = $user_id;
            $this->data['user_nik'] = get_nik($user_id);
            $this->get_user_atasan();
            $this->data['type'] = $type;
            //$this->data['inventory'] = GetJoin("inventory", "users_inventory", "users_inventory.inventory_id = inventory.id",  "left", 'users_inventory.*, inventory.title as title', array('users_inventory.user_id'=>'where/'.$user_id, 'inventory.type_inventory_id'=>'where/'.$group_id));
            $this->data['inventory'] = GetAll('inventory', array('type_inventory_id'=>'where/'.$group_id));
            $this->data['users_inventory'] = GetJoin("users_inventory", "inventory", "users_inventory.inventory_id = inventory.id",  "left", 'users_inventory.*, inventory.title as title', array('users_inventory.user_id'=>'where/'.$user_id, 'inventory.type_inventory_id'=>'where/'.$group_id));
            $this->_render_page('inventory/detail', $this->data);
        }
    }

    function input($user_id)
    {
        $this->data['title'] = 'Input Inventaris';
        $this->data['sess_nik'] = $sess_nik = get_nik($this->session->userdata('user_id'));
        $superior_it = getValue('user_app_lv1_it', 'users_exit', array('user_id'=>'where/'.$user_id));
        $superior_hrd = getValue('user_app_lv1_hrd', 'users_exit', array('user_id'=>'where/'.$user_id));
        $superior_logistik = getValue('user_app_lv1_logistik', 'users_exit', array('user_id'=>'where/'.$user_id));
        $superior_koperasi = getValue('user_app_lv1_koperasi', 'users_exit', array('user_id'=>'where/'.$user_id));
        $superior_perpus = getValue('user_app_lv1_perpus', 'users_exit', array('user_id'=>'where/'.$user_id));
        $superior_keuangan = getValue('user_app_lv1_keuangan', 'users_exit', array('user_id'=>'where/'.$user_id));
        if (!$this->ion_auth->logged_in())
        {
            $this->session->set_userdata('last_link', $this->uri->uri_string());
            redirect('auth/login', 'refresh');
        
        }elseif(is_admin_inventaris() || $sess_nik==$superior_hrd || $sess_nik==$superior_it || $sess_nik==$superior_logistik || $sess_nik==$superior_koperasi || $sess_nik==$superior_perpus){
          //  die($sess_nik.'=='.$superior_it);
            if(is_admin_it() || $sess_nik===$superior_it){
                $group_id = 2;
                $type = 'it';
            }elseif(is_admin_hrd() ||$sess_nik===$superior_hrd){
                $group_id = 1;
                $type = 'hrd';
            }elseif(is_admin_logistik() || $sess_nik===$superior_logistik){
                $group_id = 3;
                $type = 'logistik';
            }elseif(is_admin_perpus() || $sess_nik===$superior_perpus){
                $group_id = 5;
                $type = 'perpus';
            }elseif(is_admin_koperasi() || $sess_nik===$superior_koperasi){
                $group_id = 4;
                $type = 'koperasi';
            }elseif(is_admin_keuangan() || $sess_nik===$superior_keuangan){
                $group_id = 6;
                $type = 'keuangan';
            }else{
                $group_id = 0;
            }

            $num_rows = getAll('users_exit', array('user_id'=>'where/'.$user_id))->num_rows();
            $num_rows_exit = getAll('users_exit')->num_rows();
            if($num_rows>0){
               $exit_id = getValue('id', 'users_exit', array('user_id'=>'where/'.$user_id));
               $this->data['is_submit'] = getValue('is_submit_'.$type,'users_exit', array('id'=>'where/'.$exit_id));
               $this->data['user_submit'] = getValue('user_submit_'.$type,'users_exit', array('id'=>'where/'.$exit_id));
               $this->data['date_submit'] = getValue('date_submit_'.$type,'users_exit', array('id'=>'where/'.$exit_id));
               $this->data['user_edit'] = getValue('user_edit_'.$type,'users_exit', array('id'=>'where/'.$exit_id));
               $this->data['date_edit'] = getValue('date_edit_'.$type,'users_exit', array('id'=>'where/'.$exit_id));
               $this->data['is_app_lv1'] = getValue('is_app_lv1_'.$type,'users_exit', array('id'=>'where/'.$exit_id));
               $this->data['user_app_lv1'] = getValue('user_app_lv1_'.$type,'users_exit', array('id'=>'where/'.$exit_id));
               $this->data['date_app_lv1'] = getValue('date_app_lv1_'.$type,'users_exit', array('id'=>'where/'.$exit_id));
               $this->data['exit_id']  = getValue('id', 'users_exit', array('user_id'=>'where/'.$user_id));
            }else{
                $exit_id = $this->db->select('id')->order_by('id', 'asc')->get('users_exit')->last_row();
                $this->data['exit_id']  = ($num_rows_exit>0)?$exit_id->id+1:1;
                $this->data['is_submit'] = 0;
            }
            $this->db->insert_id();
            $q = $this->db->get('users_exit');
            
            $this->data['user_id'] = $user_id;
            $this->data['user_nik'] = get_nik($user_id);
            $this->get_user_atasan();
            $this->data['type'] = $type;
            $this->data['inventory'] = GetAll('inventory', array('type_inventory_id'=>'where/'.$group_id));

            $this->_render_page('inventory/input', $this->data);
        }
    }

    function add_inventory($exit_id, $type)
    {
        $num_rows = getAll('users_exit', array('id'=>'where/'.$exit_id))->num_rows();

            if($num_rows>0){
                $exit_data = array(
                'id_comp_session'=>1,
                'user_id'=>$this->input->post('emp'),
                'user_app_lv1_'.$type => $this->input->post('atasan1'),
                'edited_by'=>$this->session->userdata('user_id'),
                'edited_on' => date('Y-m-d',strtotime('now')),
                );
                $this->db->where('id',$exit_id)->update('users_exit', $exit_data);
            }else{
                $exit_data = array(
                            'id_comp_session'=>1,
                            'user_id'=>$this->input->post('emp'),
                            'user_app_lv1_'.$type => $this->input->post('atasan1'),
                            'created_by'=>$this->session->userdata('user_id'),
                            'created_on' => date('Y-m-d',strtotime('now')),
                            );
                $this->db->insert('users_exit', $exit_data);
                $exit_id = $this->db->insert_id();
            }

        $inventory_id = $this->input->post('inventory_id');
        
        $x='';
        $x2='';
        for ($i=1; $i<=sizeof($inventory_id);$i++) {
            $x .= $this->input->post('is_available_'.$i).',';
            $x2 .= $this->input->post('note_'.$i).',';
        }

        $is_available = explode(',',$x);
        $note = explode(',',$x2);
        for($i=0;$i<sizeof($inventory_id);$i++){
            $data = array(
                'user_id' => $this->input->post('emp'),
                'inventory_id' => $inventory_id[$i],
                'is_available'=>$is_available[$i],
                'note'=>$note[$i],
                'created_by'=>$this->session->userdata('user_id'),
                'created_on' => date('Y-m-d',strtotime('now')),
                );

            $this->db->insert('users_inventory', $data);
            //$this->db->insert('users_inventory_exit', $data);
        }

        $data2 = array(
            'is_submit_'.$type => 1,
            'user_submit_'.$type =>$this->session->userdata('user_id'),
            'date_submit_'.$type => date('Y-m-d',strtotime('now')),
            );
        $this->db->where('id',$exit_id)->update('users_exit', $data2);
        $user_id = $this->input->post('emp');
        $this->send_approval_request($user_id, $type);
        redirect('inventory/detail/'.$user_id,'refresh');
    }

    function update($user_id, $type)
    {

        $inventory_id = $this->input->post('inventory_id');
        $x='';
        $x2='';
        for ($i=1; $i<=sizeof($inventory_id);$i++) {
            $x .= $this->input->post('is_available_'.$i).',';
            $x2 .= $this->input->post('note_'.$i).',';
        }

        $is_available = explode(',',$x);
        $note = explode(',',$x2);
        for($i=0;$i<sizeof($inventory_id);$i++){
            $data = array(
                'user_id'=>$user_id,
                'inventory_id'=>$inventory_id[$i],
                'is_available'=>$is_available[$i],
                'note'=>$note[$i],
                'edited_by'=>$this->session->userdata('user_id'),
                'edited_on' => date('Y-m-d',strtotime('now')),
                );

        $num_rows = getAll('users_inventory', array('user_id'=>'where/'.$user_id, 'inventory_id'=>'where/'.$inventory_id[$i]))->num_rows();
        if($num_rows>0):
            $this->db->where('user_id', $user_id)->where('inventory_id', $inventory_id[$i]);
            $this->db->update('users_inventory', $data);
        else:
            $this->db->insert('users_inventory',$data);
        endif;
        }

        if(!empty($this->input->post('atasan1_update'))){
            $data2 = array(
                    'user_edit_'.$type =>$this->session->userdata('user_id'),
                    'date_edit_'.$type => date('Y-m-d',strtotime('now')),
                    'user_app_lv1_'.$type => $this->input->post('atasan1_update'),
                    'is_app_lv1_'.$type => 0,
                    );
        }else{
            $data2 = array(
                'user_edit_'.$type =>$this->session->userdata('user_id'),
                'date_edit_'.$type => date('Y-m-d',strtotime('now')),
                );
        }
        $this->db->where('user_id',$user_id)->update('users_exit', $data2);
        $this->send_approval_request_update($user_id, $type);
        redirect('inventory/detail/'.$user_id,'refresh');
    }

    function do_approve($id, $type)
    {
        if (!$this->ion_auth->logged_in())
        {
            redirect('auth/login', 'refresh');
        
        }
        
        $data = array(
            'is_app_lv1_'.$type => 1,
            'date_app_lv1_'.$type => date('Y-m-d',strtotime('now')),
            );
        $this->db->where('user_id',$id)->update('users_exit', $data);
        $this->approval_mail($id, $type);
    }

    function send_approval_request($id, $type)
    {
        $url = base_url().'inventory/detail/'.$id;
        $user_app_lv1 = getValue('user_app_lv1_'.$type, 'users_exit', array('user_id'=>'where/'.$id));
        $user_id = $this->session->userdata('user_id');
        //approval to LV1
        if(!empty($user_app_lv1)){
            $data1 = array(
                    'sender_id' => get_nik($user_id),
                    'receiver_id' => $user_app_lv1,
                    'sent_on' => date('Y-m-d-H-i-s',strtotime('now')),
                    'subject' => 'Notifikasi Inventaris Karyawan',
                    'email_body' => get_name($user_id).' telah mengisi data inventaris '.get_name($id).', untuk melihat detail silakan <a class="klikmail" href='.$url.'>Klik Disini</a><br />'.$this->detail_email($id),
                    'is_read' => 0,
                );
            $this->db->insert('email', $data1);
        }
    }

    function send_approval_request_update($id, $type)
    {
        $url = base_url().'inventory/detail/'.$id;
        $user_app_lv1 = getValue('user_app_lv1_'.$type, 'users_exit', array('user_id'=>'where/'.$id));
        $user_id = $this->session->userdata('user_id');
        //approval to LV1
        if(!empty($user_app_lv1)){
            $data1 = array(
                    'sender_id' => get_nik($user_id),
                    'receiver_id' => $user_app_lv1,
                    'sent_on' => date('Y-m-d-H-i-s',strtotime('now')),
                    'subject' => 'Notifikasi Perubahan data Inventaris Karyawan',
                    'email_body' => get_name($user_id).' telah mengubah data inventaris '.get_name($id).', untuk melihat detail silakan <a class="klikmail" href='.$url.'>Klik Disini</a><br />'.$this->detail_email($id),
                    'is_read' => 0,
                );
            $this->db->insert('email', $data1);
        }
    }

    function approval_mail($id, $type)
    {
        $url = base_url().'inventory/detail/'.$id;
        $user_admin = getValue('user_submit_'.$type, 'users_exit', array('user_id'=>'where/'.$id));
        $user_id = $this->session->userdata('user_id');
        //approval to LV1
        $data1 = array(
                'sender_id' => get_nik($user_id),
                'receiver_id' => get_nik($user_admin),
                'sent_on' => date('Y-m-d-H-i-s',strtotime('now')),
                'subject' => 'Notifikasi Inventaris Karyawan dari Atasan',
                'email_body' => get_name($user_id).' telah mengetahui pengisian data inventaris '.get_name($id).', untuk melihat detail silakan <a class="klikmail" href='.$url.'>Klik Disini</a><br />'.$this->detail_email($id),
                'is_read' => 0,
            );
        $this->db->insert('email', $data1);
    }

    function detail_email($user_id)
    { 
        $this->data['title'] = 'Inventaris Karyawan';
        $this->data['sess_nik'] = $sess_nik = get_nik($this->session->userdata('user_id'));
        $superior_it = getValue('user_app_lv1_it', 'users_exit', array('user_id'=>'where/'.$user_id));
        $superior_hrd = getValue('user_app_lv1_hrd', 'users_exit', array('user_id'=>'where/'.$user_id));
        $superior_logistik = getValue('user_app_lv1_logistik', 'users_exit', array('user_id'=>'where/'.$user_id));
        $superior_koperasi = getValue('user_app_lv1_koperasi', 'users_exit', array('user_id'=>'where/'.$user_id));
        $superior_perpus = getValue('user_app_lv1_perpus', 'users_exit', array('user_id'=>'where/'.$user_id));
        $superior_keuangan = getValue('user_app_lv1_keuangan', 'users_exit', array('user_id'=>'where/'.$user_id));

        if (!$this->ion_auth->logged_in())
        {
            $this->session->set_userdata('last_link', $this->uri->uri_string());
            redirect('auth/login', 'refresh');
        
        }elseif(is_admin_inventaris() || $sess_nik==$superior_hrd || $sess_nik==$superior_it || $sess_nik==$superior_logistik || $sess_nik==$superior_koperasi || $sess_nik==$superior_perpus){
          //  die($sess_nik.'=='.$superior_it);
            if(is_admin_it() || $sess_nik===$superior_it){
                $group_id = 2;
                $type = 'it';
            }elseif(is_admin_hrd() ||$sess_nik===$superior_hrd){
                $group_id = 1;
                $type = 'hrd';
            }elseif(is_admin_logistik() || $sess_nik===$superior_logistik){
                $group_id = 3;
                $type = 'logistik';
            }elseif(is_admin_perpus() || $sess_nik===$superior_perpus){
                $group_id = 5;
                $type = 'perpus';
            }elseif(is_admin_koperasi() || $sess_nik===$superior_koperasi){
                $group_id = 4;
                $type = 'koperasi';
            }elseif(is_admin_keuangan() || $sess_nik===$superior_keuangan){
                $group_id = 6;
                $type = 'keuangan';
            }else{
                $group_id = 0;
            }

            $num_rows = getAll('users_exit', array('user_id'=>'where/'.$user_id))->num_rows();
            $num_rows_exit = getAll('users_exit')->num_rows();
            if($num_rows>0){
               $exit_id = getValue('id', 'users_exit', array('user_id'=>'where/'.$user_id));
               $this->data['is_submit'] = getValue('is_submit_'.$type,'users_exit', array('id'=>'where/'.$exit_id));
               $this->data['user_submit'] = getValue('user_submit_'.$type,'users_exit', array('id'=>'where/'.$exit_id));
               $this->data['date_submit'] = getValue('date_submit_'.$type,'users_exit', array('id'=>'where/'.$exit_id));
               $this->data['user_edit'] = getValue('user_edit_'.$type,'users_exit', array('id'=>'where/'.$exit_id));
               $this->data['date_edit'] = getValue('date_edit_'.$type,'users_exit', array('id'=>'where/'.$exit_id));
               $this->data['is_app_lv1'] = getValue('is_app_lv1_'.$type,'users_exit', array('id'=>'where/'.$exit_id));
               $this->data['user_app_lv1'] = getValue('user_app_lv1_'.$type,'users_exit', array('id'=>'where/'.$exit_id));
               $this->data['date_app_lv1'] = getValue('date_app_lv1_'.$type,'users_exit', array('id'=>'where/'.$exit_id));
               $this->data['exit_id']  = getValue('id', 'users_exit', array('user_id'=>'where/'.$user_id));
            }else{
                $exit_id = $this->db->select('id')->order_by('id', 'asc')->get('users_exit')->last_row();
                $this->data['exit_id']  = ($num_rows_exit>0)?$exit_id->id+1:1;
                $this->data['is_submit'] = 0;
            }
            $this->db->insert_id();
            $q = $this->db->get('users_exit');
            
            $this->data['user_id'] = $user_id;
            $this->data['user_nik'] = get_nik($user_id);
            $this->get_user_atasan();
            $this->data['type'] = $type;
            //$this->data['inventory'] = GetJoin("inventory", "users_inventory", "users_inventory.inventory_id = inventory.id",  "left", 'users_inventory.*, inventory.title as title', array('users_inventory.user_id'=>'where/'.$user_id, 'inventory.type_inventory_id'=>'where/'.$group_id));
            $this->data['inventory'] = GetAll('inventory', array('type_inventory_id'=>'where/'.$group_id));
            $this->data['users_inventory'] = GetJoin("users_inventory", "inventory", "users_inventory.inventory_id = inventory.id",  "left", 'users_inventory.*, inventory.title as title', array('users_inventory.user_id'=>'where/'.$user_id, 'inventory.type_inventory_id'=>'where/'.$group_id));
            return $this->load->view('inventory/inventory_mail', $this->data, TRUE);
        }
    }

    function _render_page($view, $data=null, $render=false)
    {
        $data = (empty($data)) ? $this->data : $data;
        if ( ! $render)
        {
            $this->load->library('template');

                if(in_array($view, array('inventory/index')))
                {
                    $this->template->set_layout('default');

                    $this->template->add_js('jquery.sidr.min.js');
                    $this->template->add_js('breakpoints.js');
                    $this->template->add_js('core.js');
                    $this->template->add_js('select2.min.js');

                    $this->template->add_js('form_index.js');

                    $this->template->add_css('jquery-ui-1.10.1.custom.min.css');
                    $this->template->add_css('plugins/select2/select2.css');
                    
                }
                elseif(in_array($view, array('inventory/input', 'inventory/detail')))
                {

                    $this->template->set_layout('default');
                    $this->template->add_js('jquery.sidr.min.js');
                    $this->template->add_js('breakpoints.js');
                    $this->template->add_js('select2.min.js');

                    $this->template->add_js('core.js');
                    $this->template->add_js('purl.js');

                    $this->template->add_js('respond.min.js');

                    $this->template->add_js('jquery.bootstrap.wizard.min.js');
                    $this->template->add_js('jquery.validate.min.js');
                    $this->template->add_js('inventory.js');
                    
                    $this->template->add_css('jquery-ui-1.10.1.custom.min.css');
                    $this->template->add_css('plugins/select2/select2.css');
                    $this->template->add_css('approval_img.css');
                     
                }


            if ( ! empty($data['title']))
            {
                $this->template->set_title($data['title']);
            }

            $this->template->load_view($view, $data);
        }
        else
        {
            return $this->load->view($view, $data, TRUE);
        }
    }
}   