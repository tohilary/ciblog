<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('json/Json.php');

/**
* �׳�json��ִ��Ϣ
* 
* @access public
* @param string $message ��Ϣ��
* @param string $charset ��Ϣ����
* @return void
*/
function throwJson($message, $charset = NULL)
{
   /** ����httpͷ��Ϣ */
  header('content-Type: application/json; charset=' . (empty($charset) ? 'UTF-8' : $charset), true);
  echo json::encode($message);
  /** ��ֹ������� */
  exit;
}

/* End of file Json_pi.php */
/* Location: ./application/plugins/Json_pi.php */ 