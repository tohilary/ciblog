<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
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
 * STBLOG Plugins Class
 *
 * ��������������Model
 *
 * @package		STBLOG
 * @subpackage	Models
 * @category	Models
 * @author		Saturn <huyanggang@gmail.com>
 * @link		http://code.google.com/p/stblog/
 */
class Plugins_mdl extends Model {
	
	/**
     * ϵͳ���ڲ��Ŀ¼
     * 
     * @access private
     * @var string
     */
	public $plugins_dir = '';
	
	/**
     *	�Ѿ�����Ĳ�� 
     *
     * @access public
     * @var string
     */
	public $active_plugins = array();
	
	/**
     * ���캯��
     * 
     * @access public
     * @return void
     */
    public function __construct()
    {
       parent::Model();
       
       /** ��ʼ�����Ŀ¼ */
       $this->plugins_dir = FCPATH. ST_PLUGINS_DIR . DIRECTORY_SEPARATOR ;
       
       /** ��ʼ���Ѽ����� */
       $this->active_plugins = $this->utility->get_active_plugins();
       
	   log_message('debug', "STBLOG: Plugins Model Class Initialized");
    }
    
	
	/**
	 * ����һ�����
	 *
     * @access public
	 * @param array $plugin ��Ҫ����Ĳ�����
	 * @return void
	 */
	public function active($plugin)
	{
		if (in_array($plugin, $this->active_plugins))
		{	
			return;
		} 
		else 
		{	
			$this->active_plugins[] = $plugin;
		}
		
		$active_plugins = serialize($this->active_plugins);
		
		$this->db->query("update settings set value='$active_plugins' where name='active_plugins'");
		
		$this->utility->clear_db_cache();
	}
	
	/**
	 * ���ò��
	 *
     * @access public
	 * @param array $plugin ��Ҫ���õĲ��
	 * @return void
	 */
	public function deactive($plugin)
	{
		if (!in_array($plugin, $this->active_plugins))
		{
			return;
		} 
		else
		{
			$key = array_search($plugin, $this->active_plugins);
			
			unset($this->active_plugins[$key]);
		}
		
		$active_plugins = serialize($this->active_plugins);
		
		$this->db->query("update settings set value='$active_plugins' where name='active_plugins'");
		
		$this->utility->clear_db_cache();
	}

	/**
	 * ��ȡ���������Ϣ
	 *
     * @access public
	 * @param array $name ����ļ�����
	 * @return array �����Ϣ
	 */
	public function get($plugin)
	{
		$plugin = strtolower($plugin);
		
		$path = $this->plugins_dir . $plugin;
				
		$file = $path . DIRECTORY_SEPARATOR . ucfirst($plugin) . '.php';
		
		$config = $path . DIRECTORY_SEPARATOR . ucfirst($plugin) . '.config.php';

		if(!is_file($path) && file_exists($file))
		{
			$fp = fopen($file, 'r' );
			
			/** ֻȡ�ļ�ͷ�����4K�����ݽ��з��� */
			$plugin_data = fread($fp, 4096);
			
			fclose($fp);
			
			preg_match( '|Plugin Name:(.*)$|mi', $plugin_data, $name );
			preg_match( '|Plugin URI:(.*)$|mi', $plugin_data, $uri );
			preg_match( '|Version:(.*)|i', $plugin_data, $version );
			preg_match( '|Description:(.*)$|mi', $plugin_data, $description );
			preg_match( '|Author:(.*)$|mi', $plugin_data, $author_name );
			preg_match( '|Author Email:(.*)$|mi', $plugin_data, $author_email );
			
			foreach( array('name', 'uri', 'version', 'description', 'author_name', 'author_email' ) as $field ) 
			{		
				${$field} = (!empty(${$field}))?trim(${$field}[1]):'';
			}
			
			return array(
						  'directory' => $plugin,
						  'name' => ucfirst($name), 
						  'plugin_uri' => $uri, 
						  'description' => $description, 
						  'author' => $author_name, 
						  'author_email' => $author_email, 
						  'version' => $version,
						  'configurable' => (file_exists($config))?TRUE:FALSE
						  );
		}
		
		return;
	}
	
	/**
     * ��ȡ���в����Ϣ
     *
     *	�ݹ��ȡ���д����st_plugins�еĲ����Ϣ������ԭ����Ƿ�����.plugin.php��β�Ĳ���ļ���ͷ��ע�ͣ�
     *	��ȡ���еĲ����Ϣ��(�������wordpress����лWP�����û�������������ô���ܾ�Ҫ��дһ��xml��php��
     *	����������Ϣ��)
     *	
     *	���������д�Ĳ����ϵͳ�Զ����֣���Ҫ������ѭ����������Ϸ����
     *	
     *	1.�����ʵ���ļ�������.plugin.php��β����һ��fckeditor���������fckeditor.plugin.php������ֵ��
     *	  ע����ǣ�����������ʶ��"���Ŀ¼/���/���.plugin.php"Ŀ¼�µĲ��
     *	2.�ڲ����ʵ���ļ���ͷ�������������¸�ʽ���������Ϣ��
     *			/*
     *				Plugin Name: �������
	 *				Plugin URI: �������Ŀ��ҳ
	 *				Description: ����
	 *				Version: �汾��
	 *				Author: ����
	 *				Author Email: ������ҳ
     *
     *         
     * 
     * @access public
     * @return array - ���в����Ϣ
     */
	public function get_all_plugins_info()
	{
		$data = array();
				
		$this->load->helper('directory');
		
		$plugin_dirs = directory_map($this->plugins_dir, TRUE);
		
		if($plugin_dirs)
		{
			foreach($plugin_dirs as $plugin_dir)
			{
				$data[] = $this->get($plugin_dir);
			}
		}
		
		return $data;
	}
}

/* End of file plugins_mdl.php */
/* Location: ./application/models/plugins_mdl.php */