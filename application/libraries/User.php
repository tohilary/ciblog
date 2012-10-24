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
 * STBLOG User library Class
 *
 * ��������û�Domain�ĺ����߼� 
 *			
 *
 * @package		STBLOG
 * @subpackage	Libraries
 * @category	Libraries
 * @author		Saturn <huyanggang@gmail.com>
 * @link 		http://code.google.com/p/stblog/
 */
class User
{
	/**
     * user domain
     *
     * @access private
     * @var array
     */
    private $_user = array();

	/**
     * �û�ID
     *
     * @access public
     * @var integer
     */
	public $uid = 0;

	/**
     * ��¼�û���
     *
     * @access public
     * @var string
     */
	public $name = '';

	/**
     * Email
     *
     * @access public
     * @var string
     */
	public $mail = '';

	/**
     * �ǳ�
     *
     * @access public
     * @var string
     */
	public $screenName = '';

	/**
     * �ʺŴ�������
     *
     * @access public
     * @var string
     */
	public $created = 0;

	/**
     * ����Ծʱ��
     *
     * @access public
     * @var string
     */
	public $activated = 0;

	/**
     * �ϴε�¼
     *
     * @access public
     * @var string
     */
	public $logged = 0;

	/**
     * �����û���
     *
     * @access public
     * @var string
     */
	public $group = 'visitor';

	/**
     * ���ε�¼Token
     *
     * @access public
     * @var string
     */
	public $token = '';

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
        /** ��ȡCI��� */
		$this->_CI = & get_instance();
		
		$this->_user = unserialize($this->_CI->session->userdata('user'));
		
		/** ��ʼ������ */
		if(!empty($this->_user))
		{
			$this->uid = $this->_user['uid'];
			$this->name = $this->_user['name'];
			$this->mail = $this->_user['mail'];
			$this->url = $this->_user['url'];
			$this->screenName = $this->_user['screenName'];
			$this->created = $this->_user['created'];
			$this->activated = $this->_user['activated'];
			$this->logged = $this->_user['logged']; 
			$this->group = $this->_user['group']; 
			$this->token = $this->_user['token'];
		}
		
		log_message('debug', "STBLOG: User Domain library Class Initialized");
    }
}

/* End of file User.php */
/* Location: ./application/libraries/User.php */