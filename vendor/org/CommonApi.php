<?php
namespace app\vendor\org;

class CommonApi
{

	private $appid = '';
	private $mch_id = '';
	private $key = '';

	public function __construct($apiConfig = false)
	{
		if($apiConfig){
			$this->appid = $apiConfif['appid'];
			$this->mch_id = $apiConfif['mch_id'];
			$this->key = $apiConfif['key'];
		}else{
			$this->appid = 'LBer7abu55ivwdz05t';
			$this->mch_id = '18094259843';
			$this->key = 'q53r2s96p3w269a3iakplehw3t2x94vf';
		}

	}

	public function user($data)
	{
		$api = 'https://lepay.51ao.com/pay/api/user.php';
		$datas=[
		'appid'=>$this->appid,
		'mch_id'=>$this->mch_id,
		'password'=>$data['password'],
		'username'=> $data['username'],
		'nickname'=>$data['nickname'],
		'openid'=>$data['openid'],
		'type'=>'addUser',
		'head_url'=>$data['head_url'],
		];
		$xml = $this->arr_xml($datas,$this->key);

		$ret=$this->post($api,$xml);
		$ret = $this->xml_arr($ret);
		if($ret['return_code'] == 'error' ){
			return $ret;
		}else{
			return $ret;
		}

	}

	//注册用户
	public function add_user($password,$username,$openid,$nickname,$head_url)
	{
		$data = array();
		if(!empty($password)){
			$data['password'] = $password;
		}else{
			$data['password'] = 111111;
		}

		if (!empty($username)) {
			$data['username'] = $username;
		}else{
			$data['username'] = 'demo'.time();
		}

		if (!empty($nickname)) {
			$data['nickname'] = $nickname;
		}else{
			$data['nickname'] = 'demo';
		}

		if (!empty($openid)) {
			$data['openid'] = $openid;
		}else{
			$data['openid'] = 'openid'.time();
		}

		if(!empty($head_url)){
			$data['head_url'] = $head_url;
		}else{
			$data['head_url'] = 'https://lepay.51ao.com/pay_cashier_tpl/Merchants/Static/images/1.jpg';
		}

		return $this->user($data);
	}

	public function userLogin($data)
	{
		$api = 'https://lepay.51ao.com/pay/api/user.php';
		$datas=[
		'appid'=>$this->appid,
		'mch_id'=>$this->mch_id,
		'password'=>$data['password'],
		'username'=> $data['username'],
		'type'=>'login',
		];

		$xml = $this->arr_xml($datas,$this->key);
		$ret=$this->post($api,$xml);
		$ret = $this->xml_arr($ret);
		if($ret['return_code'] == 'error' ){
			return false;
		}else{
			return $ret;
		}
	}

	public function get_userinfo($data)
	{
		$api='https://lepay.51ao.com/pay/api/user.php';
		$datas=['api'=>$this->appid,
		'mch_id'=>$this->mch_id,
		'username'=>$data['username'],
		'type'=>'get_user',
		];
		$xml=$this->arr_xml($datas,$this->key);//拼接xml
		$ret=$this->post($api,$xml);
		$ret=$this->xml_arr($ret);
		if($ret['return_code']=='error')
		{
			return false;
		}else
		{
			return $ret;
		}
	}

	public function weixLogin($data)
	{
		$api = 'https://lepay.51ao.com/pay/api/user.php';
		$datas=[
		'appid'=>$this->appid,
		'mch_id'=>$this->mch_id,
		'openid'=> $data['openid'],
		'type'=>'weixfind',
		];
		$xml = $this->arr_xml($datas,$this->key);
		$ret=$this->post($api,$xml);
		$ret = $this->xml_arr($ret);

		if($ret['return_code'] == 'error' ){
			return false;
		}else{
			return $ret;
		}

	}

	public function arr_xml($data,$key)
	{
		ksort($data);//以键名排序
		$string='';
		foreach($data as $k=>$v){
		    $string.="$k=$v&";
		}
		$string.='key='.$key;
		$sign=strtoupper(md5($string));
		$data['sign']=$sign;
		$xml='<xml>';
		foreach($data as $k=>$v){
		    $xml.="<$k>$v</$k>";
		}
		$xml.='</xml>';
		return $xml;
	}

	public function xml_arr($xml)
	{
		return json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
	}

	 public function getinfo($url)
    {
        $api='https://lepay.51ao.com/pay/api/wx_location.php';
        //构造参数
        $data=[
        'appid'=>$this->appid,
        'mch_id'=>$this->mch_id,
        'url'=>$url,
        ];
        $xml = $this->arr_xml($data,$this->key);
        $ret=$this->post($api,$xml);
        $ret =  json_decode(json_encode(simplexml_load_string($ret, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $ret;
        }

	public function post($url, $data, $isHttps = TRUE)
    {
        // 创建curl对象
        $ch = curl_init ();
        // 配置这个对象
        curl_setopt ( $ch, CURLOPT_URL, $url);  // 请求的URL地址
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
        if($isHttps)
        {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); // 从证书中检查SSL加密算法是否存在
        }
        curl_setopt ( $ch, CURLOPT_POST, true);  // 是否是POST请求
        curl_setopt ( $ch, CURLOPT_HEADER, 0);  // 去掉HTTP协议头
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1);  // 返回接口的结果，而不是输出
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data);  // 提交的数据
        // 发出请求
        $return = curl_exec ( $ch );
        // 关闭对象
        curl_close ( $ch );
        // 返回数据
        return $return;
    }
    //短信api接口
    public function message($tel,$code)
    {
        $api='https://lepay.51ao.com/pay/api/message.php';
        $data=[
        'appid'=>$this->appid,
        'mch_id'=>$this->mch_id,
        'projectName'=>'点餐网',
        'rand_num'=> $code,
        'tel'=>$tel,
        ];
       	$xml = $this->arr_xml($datas,$this->key);
        $ret=$this->post($api,$xml);
        return json_decode(json_encode(simplexml_load_string($ret, 'SimpleXMLElement', LIBXML_NOCDATA)), true);

    }
    //客户微信支付
    public function paying($fee,$goods_name,$truename,$openid,$trade_no)
	{
		$api='https://lepay.51ao.com/pay/api/index.php';
		//构造参数
		$data=[
		'appid'=>$this->appid,
		'mch_id'=>$this->mch_id,
		'openid'=> $openid,
		'goods_name'=>$goods_name,
		'out_trade_no'=>$trade_no,
		'total_fee'=>$fee,//单位是分
		'notify_url'=>'http://dc.51ao.com/api/weixin/weixin_return.php',
		'tname'=>$truename,
		'trade_type'=>'weixin',
		];
		$xml = $this->arr_xml($data,$this->key);
		$ret=$this->post($api,$xml);
		return json_decode(json_encode(simplexml_load_string($ret, 'SimpleXMLElement', LIBXML_NOCDATA)), true);

		}

		//二维码支付
	public function pay_qrcode($fee,$goods_name,$truename,$trade_no,$paytype)
    {
        $api='https://lepay.51ao.com/pay/api/pay_code.php';
        //构造参数
        $data=[
        'appid'=>$this->appid,
        'mch_id'=>$this->mch_id,
        'goods_name'=>$goods_name,
        'out_trade_no'=>$trade_no,
        'total_fee'=>$fee,//单位是分
        'notify_url'=>'http://dc.51ao.com/api/weixin/weixin_qrcode.php',
        'tname'=>$truename,
        'trade_type'=>$paytype,
        ];
        if($paytype == ''){
            $data['trade_type'] = 'weixin';
        }else{
            $data['trade_type'] = 'alipay';

        }
        $xml = $this->arr_xml($data,$this->key);
        $ret=$this->post($api,$xml);
        return json_decode(json_encode(simplexml_load_string($ret, 'SimpleXMLElement', LIBXML_NOCDATA)), true);

    }

}