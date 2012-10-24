<?php if (!defined('BASEPATH')) exit('No direct access allowed.');
/**
 * STBlog Blogging System
 *
 * ����Codeigniter�ĵ��û���Ȩ�޿�Դ����ϵͳ
 * 
 * STBlog is an open source multi-privilege blogging System built on the 
 * well-known PHP framework Codeigniter.
 *
 * @package		STBLOG
 * @author		Saturn <huyanggang@gmail.com>
 * @copyright	Copyright (c) 2009 - 2010, cnsaturn.com.
 * @license		GNU General Public License 2.0
 * @link		http://code.google.com/p/stblog/
 * @version		0.1.0
 */
 
// ------------------------------------------------------------------------

/**
 * STBLOG ǰ̨��������
 *
 * ǰ̨�����п���������Ҫ�̳�����࣬����������֤
 *
 * @package		STBLOG
 * @subpackage	Libraries
 * @category	Libraries
 * @author		Saturn <huyanggang@gmail.com>
 * @link 		http://code.google.com/p/stblog/
 */
class ST_Controller extends Controller {
    
	protected function __construct() {
		
		parent::Controller();

		/** ���������ϵ�PHP�汾 */
		$this->utility->check_compatibility();
		
		/** ���վ�㵱ǰ״̬ */
		$this->utility->check_blog_status();
	    
	    /** ���õ�ǰʹ�õ�����Ƥ�� */
		$this->load->theme = setting_item('current_theme');
	    
	    /** ǰ̨ҳ���ʹ������Ƥ������ */
	    $this->load->switch_theme_on();
    }


    /**
     * ����ĳ������ҳ���µ�VIEW
     *
     * ��1/2/4�������ֱ��ӦCIԭ�е�load view�еĵ�1/2/3����������ĵ�������������һЩ���ⳡ�ϣ�
	 * ����վ���湦�ܱ�����ʱ��Ϊ�˱��⵱ǰ��������ҳ�滺�棬�������õ���������ΪFALSE���⡣
     *
     *
     * @access   public
     * @param    string
     * @param    array
	 * @param	 bool
     * @param    bool
     * @return   void
     */
	protected function load_theme_view($view, $vars = array(), $cached = TRUE, $return = FALSE)
	{
		/** ���ض�Ӧ�����µ�view */
		if(file_exists(FCPATH. ST_THEMES_DIR. DIRECTORY_SEPARATOR . setting_item('current_theme'). DIRECTORY_SEPARATOR . $view .'.php')) 
		{
			echo $this->load->view($view, $vars,$return);
		}
		else 
		{
			show_404();
		}
		
		/** �Ƿ�������? */
		if(1 == intval(setting_item('cache_enabled')) && $cached)
		{
			$cache_expired = setting_item('cache_expire_time');
			
			$cache_expired = ($cache_expired && is_numeric($cache_expired)) ? intval($cache_expired) : 60;
			
			/** �������� */
			$this->output->cache($cache_expired);
		}
		
	}	

}

// ------------------------------------------------------------------------

/**
 * STBLOG ��̨��������
 *
 * ��̨�����п���������Ҫ�̳�����࣬��Ҫ������֤
 *
 * @package		STBLOG
 * @subpackage	Controller
 * @category	Controller
 * @author		Saturn <huyanggang@gmail.com>
 * @link 		http://code.google.com/p/stblog/
 */
class ST_Auth_Controller extends Controller {


    protected function __construct() {
        
		parent::Controller();
		
		/** ������֤�� */
		$this->load->library('auth');
		
		/** ����½ */		
		if(!$this->auth->hasLogin())
		{
			redirect('admin/login?ref='.urlencode($this->uri->uri_string()));
		}
		
		/** ���غ�̨������������ */
	   	$this->load->library('form_validation');
	   	$this->load->library('user');

		/** ���غ�̨����������ģ�� */
		$this->load->model('users_mdl');
		
		/** ���غ�̨������helper */
		
		
	    /** ��̨����ҳ�棬��ʹ��Ƥ�� */
	    $this->load->switch_theme_off();
    }
}

/* End of file MY_Controller.php */
/* Location: ./application/libraries/MY_Controller.php */