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
 * STBLOG Plugin Manager Class
 *
 * ��������࣬���ڹ���STBlog�ĵ�����������ܵ�68KB��������
 *
 * @package		STBLOG
 * @subpackage	Libraries
 * @category	Libraries
 * @author		Saturn <huyanggang@gmail.com>
 * @link 		http://code.google.com/p/stblog/
 */
class Plugin
{
	/**
     * ��ע��Ĳ��(��ͷ���)
     *
     * @access private
     * @var array
     */
    private $_listeners = array();
	
	/**
    * CI���
    * 
    * @access private
    * @var object
    */
	private $_CI;

	 /**
     * ���캯��
     * 
     * @access public
     * @return void
     */
    public function __construct()
    {
        /** ��ȡCI��� **/
		$this->_CI = & get_instance();
		
		$plugins = $this->_CI->utility->get_active_plugins();
		
		if($plugins && is_array($plugins))
		{
			foreach($plugins as $plugin)
			{
				$plugin_dir = $plugin['directory'] . '/' . ucfirst($plugin['directory']) . '.php';
				
				$path = FCPATH . ST_PLUGINS_DIR . '/' . $plugin_dir;
				
				/** ����ʶ��"���Ŀ¼/���/���.php"Ŀ¼�µĲ�� */
				if (preg_match("/^[\w\-\/]+\.php$/", $plugin_dir) && file_exists($path))
				{
					include_once($path);

					$class = ucfirst($plugin['directory']);
					
					if (class_exists($class)) 
					{
						/** ��ʼ����� */
						new $class($this);
					}
				}
			}
		}
		
		log_message('debug', "STBLOG: Plugins Libraries Class Initialized");
    }
	
	/**
	 * ע����Ҫ�����Ĳ�����������ӣ�
	 *
	 * @param string $hook
	 * @param object $reference
	 * @param string $method
	 */
	public function register($hook, &$reference, $method)
	{
		$key = get_class($reference).'->'.$method;
		$this->_listeners[$hook][$key] = array(&$reference, $method);
		
		log_message('debug', "$hook Registered: $key");
	}

	/**
	 * ����һ������
	 *
	 *	e.g.: $this->plugin->trigger('hook_name'[, arg1, arg2, arg3...]);	
	 *
	 *
	 * @param string $hook ���ӵ�����
	 * @param mixed $data ���ӵ����
	 * @return mixed
	 */
	public function trigger($hook)
	{
		$result = '';
		
		if($this->check_hook_exist($hook))
		{
			foreach ($this->_listeners[$hook] as $listener)
			{
				$class  = & $listener[0];
				$method = $listener[1];
				
				if(method_exists($class, $method))
				{
					$args = array_slice(func_get_args(), 1);
					
					$result = call_user_func_array(array($class, $method), $args);
				}
			}
		}
		
		log_message('debug', "Hook Triggerred: $hook");
		
		return $result;
	}

	/**
	 * ��鹳���Ƿ����
	 *
	 *
	 * @param string $hook ���ӵ�����
	 * @return array
	 */
	public function check_hook_exist($hook)
	{
		if(isset($this->_listeners[$hook]) && is_array($this->_listeners[$hook]) && count($this->_listeners[$hook]) > 0)
		{
			return TRUE;
		}
		
		return FALSE;
	}
}

/* End of file Plugin.php */
/* Location: ./application/libraries/Plugin.php */