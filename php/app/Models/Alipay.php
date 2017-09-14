<?php
namespace App\Models;
/**
 * Created by PhpStorm.
 * User: Lee
 * Date: 2017/6/13
 * Time: 13:39
 */

class AliPay{
    //App
    private  $app_id = '2017032106327228';
    //支付宝账号
    private  $seller_id = 'ldbaobei888@163.com';
    //private  $back_url = $this->SetUrl();
    private  $private_key = 'MIIEvAIBADANBgkqhkiG9w0BAQEFAASCBKYwggSiAgEAAoIBAQCr5b+I8keyMiUd1LzJvjjEwglheQuUQrYWszy+ErLf6vsVLg4Cv6DhbztKvQzfpSjLOWKRGHDnsRLRrZ69GoqsY4B9nxlLFQpnAl4TVp4O7Jovjh/NxXcrOuU0uFsxql/aVXsAzddUDCnOgUjJNQa7Jx4OnZwKkPAYCrspxdDaFAohDO1XHrFDQMzXpHY7Rd/68BMtmkC95JPJvln5mHwweph2lnUURgZFJhyzDwWTbzE206DJys7vCFrTOEkaVAIj0t0HJqqLzDgI/19oKPSZive3tGrdkWzUQOkKSWflEEDsTKktTuDXxRwMeXtFFBJRa7Z+9D4DePfnqUem/zLdAgMBAAECggEAVMMJW0H80IWhf8AzB1fhLkRv07yYVRdAKplfTmpyAbAg9ySqi/hqID91ATmPa4hJQUyeqeVfZyANo471Q1IfJzo5VbhqBHfvlTO5p9eCQOGyddijHhhM1uhHtWNitG7KrSKRcKgPkcYdp1JgzbZ0Bz0WuSZGl384pOJFwCdnAOEpDpi+nrvU7IrfyK0IzIjmuIClHu7cLrwgarJL0UMiqFP2/aL4wl/wvZL50cKlLr7dSvsPCrprrDeXlJMucSb/WSW2oDNFn6ykEK1Gi0ZqxnWXNpezD/DQrQzZNq5HY5h5yVHbgYqqfnOxTjch54AaM/uaWM+1WcUSxqBZt6a6gQKBgQDl10+NzqaKj9KiTIKzkHWe19S53CUwO0cn6o/8zJVom8jCvW/rNWCQ/Dur3mVKhRfQy6TJxdCqLASuKNzoS8DtFs5B6xX25Cm7Yaaon84gzIlezwKhmRmQrTz+C6ynC2RTgnRis2iP3JKqJc1aRH6p96gBPsd897f+I1P8va+omQKBgQC/di61UG1ZPSTfEYKl2esxwf2tStW3lWcl6oDrrRl62nLo4Zly2u4NZw1tl8G5534ZE5C8q15RtHGxk1ynRsCUt4ysDAxYoEwL7qne7QJXO16V7c4BnCW43rF7XVxZSDJ91DihEwazRAdB4Ug39F5CMt7AFZpPmCv6h6CsaZuy5QKBgDZHS8VMeS4d2vtzICaxxeU2SUl/QNUMGrjFfy2PTvV+XMIIpMaiO2Th/GGRStB3b/FiNk9kROv7KzvJ8Kl3Ql97VEhi8TP2HBjhbc9CthYu134pWxC4rD3re4zvSt3EJfRGyZ+JiPb4ezZtaPqZVGRlVSq+HbRYd/4vb6UvUq15AoGAEkDKIy8Pvbo+kaWxtu4Xph7AeIzx4xazRsIcmFtgWn4JBnq7jl+g4lY4yYH2TirrsqhS3CnaTB/P1wYdhzUPlx4Ioz5izvA5T8npF/+wgXB/i/un8C9ayU0xznkQHNLtPWHGJFUUBnMt3fIEWJFLizQeWGG23G+9gZz8jHNlDKECgYAQDv/55SKtK4zzywz7kB3FYcmzOfD+QICd11+QRqiY6RiJTvft3JmQOPcLma0GkNvy9p5JVv3O+rhfj7K1Tw4ZlpQvpvx5mEsbgxhbctd1Ts9kZgwwnhPRJgoSn1U7B7+8uY+/QEE0v+knh3Inw54Qhe1KzNrU5bk87lHu8Ow1vA==';

    private $public_key = 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAq+W/iPJHsjIlHdS8yb44xMIJYXkLlEK2FrM8vhKy3+r7FS4OAr+g4W87Sr0M36UoyzlikRhw57ES0a2evRqKrGOAfZ8ZSxUKZwJeE1aeDuyaL44fzcV3KzrlNLhbMapf2lV7AM3XVAwpzoFIyTUGuyceDp2cCpDwGAq7KcXQ2hQKIQztVx6xQ0DM16R2O0Xf+vATLZpAveSTyb5Z+Zh8MHqYdpZ1FEYGRSYcsw8Fk28xNtOgycrO7wha0zhJGlQCI9LdByaqi8w4CP9faCj0mYr3t7Rq3ZFs1EDpCkln5RBA7EypLU7g18UcDHl7RRQSUWu2fvQ+A3j356lHpv8y3QIDAQAB';

    public function back_url(){
       return url('alipay/alipayNotify');
    }
    //公共参数
    /**
   * app_id : 支付宝分配给开发者的应用ID        必须
   * method : 接口名称                        alipay.trade.app.pay     必须
   * format : 仅支持JSON
   * charset : 请求使用的编码格式，如utf-8,gbk,gb2312等               必须
   * sign_type : 商户生成签名字符串所使用的签名算法类型，目前支持RSA2和RSA，推荐使用RSA2     必须
   * sign : 商户请求参数的签名串                必须
   * timestamp : 发送请求的时间，格式"yyyy-MM-dd HH:mm:ss"      2014-07-24 03:07:50     必须
   * version : 调用的接口版本  固定为：1.0      必须
   * notify_url : 支付宝服务器主动通知商户服务器里指定的页面http/https路径。    必须
   * biz_content : 请求参数的集合，最大长度不限，除公共参数外所有请求参数都必须放在这个参数中传递，具体参照各产品快速接入文档                                                        必须
   */
    //业务参数
    /**
     * body : 对一笔交易的具体描述信息。如果是多种商品，请将商品描述字符串累加传给body
     * subject : 商品的标题/交易标题/订单标题/订单关键字等         必须
     * out_trade_no : 商户网站唯一订单号                         必须
     * timeout_express : 设置未付款支付宝交易的超时时间，一旦超时，该笔交易就会自动被关闭
     * total_amount : 订单总金额，单位为元，精确到小数点后两位，取值范围[0.01,10000000    必须
     * seller_id : 收款支付宝用户ID。 如果该值为空，则默认为商户签约账号对应的支付宝用户ID
     * product_code : 销售产品码，商家和支付宝签约的产品码，为固定值   QUICK_MSECURITY_PAY
     * goods_type : 商品主类型：0—虚拟类商品，1—实物类商品 注：虚拟类商品不支持使用花呗渠道
     * passback_params : 公用回传参数，如果请求时传递了该参数，则返回给商户时会回传该参数。支付宝会在异步通知时将该参数原样返回。本参数必须进行UrlEncode之后才可以发送给支付宝
     * promo_params : 优惠参数  注：仅与支付宝协商后可用  {"storeIdType":"1"}
     * extend_params : 业务扩展参数
     * enable_pay_channels : 可用渠道，用户只能在指定渠道范围内支付 当有多个渠道时用“,”分隔 注：与disable_pay_channels互斥
     * disable_pay_channels : 禁用渠道，用户不可用指定渠道支付 当有多个渠道时用“,”分隔 注：与enable_pay_channels互斥
     * store_id : 商户门店编号。该参数用于请求参数中以区分各门店，非必传项。
     */

    //业务扩展参数说明
    /**
     * sys_service_provider_id : 系统商编号，该参数作为系统商返佣数据提取的依据，请填写系统商签约协议的PID
     * needBuyerRealnamed : 是否发起实名校验 T：发起 F：不发起
     * TRANS_MEMO : 账务备注 注：该字段显示在离线账单的账务备注中
     * hb_fq_num : 花呗分期数（目前仅支持3、6、12）
     * hb_fq_seller_percent : 卖家承担收费比例，商家承担手续费传入100，用户承担手续费传入0，仅支持传入100、0两种，其他比例暂不支持
     */

    public function getData($order_id,$money,$subject=null){
        $data = array();
        $data['app_id'] = $this->app_id;
        $data['method'] = 'alipay.trade.app.pay';
        $data['charset'] = 'utf-8';
        $data['sign_type'] = 'RSA2';
        $data['timestamp'] = date('Y-m-d H:i:s',time());
        $data['version'] = '1.0';
        $data['notify_url'] = $this->back_url();
        $biz_content = array();
        $biz_content['body'] = '';
        $biz_content['subject'] = '铃铛宝贝商品交易费用';
        $biz_content['out_trade_no'] = $order_id;
        $biz_content['timeout_express'] = '60m';
        $biz_content['total_amount'] = $money;
//        $biz_content['seller_id'] = '';
        $biz_content['product_code'] = 'QUICK_MSECURITY_PAY';

        $data['biz_content'] = json_encode($biz_content);
        //1. 排序
        ksort($data);
        //2. 签名
        $sign = $this->getSing($this->getString($data));
        $data['sign'] = $sign;

        $out = array();
        //3. 对请求字符串所有一级$value进行encode
        foreach($data as $k=>$v){
            $out[$k] = json_encode($v);
        }
        //4. 获取最终的签名字符串
        $string = $this->getString($data);
        return $string;
    }

    //获取带签名的字符串
    private function getString($arr){
        $string = '';

        foreach($arr as $k=>$v){
            $string .= $k.'='.$v.'&';
        }

        $string = rtrim($string,'&');
        return $string;
    }

    //获取签名
    private function getSing($signData,$signType='RSA2'){

        $signature = '';
        $priKey = $this->getFormatPriKey();
        if("RSA2" == $signType){
            openssl_sign($signData,$signature,$priKey,OPENSSL_ALGO_SHA256);
        }else{
            openssl_sign($signData,$signature,$priKey);
        }

        return base64_encode($signature);
    }

    //验证签名
    private function verify($signData,$sign,$signType){
        if("RSA2" == $signType){
            $res = (bool)openssl_verify($signData,base64_decode($sign),$this->getFormatPubKey(),OPENSSL_ALGO_SHA256);

        }else{
            $res = (bool)openssl_verify($signData,base64_decode($sign),$this->getFormatPubKey());
        }

        return $res;
    }

    //格式化私钥
    private function getFormatPriKey(){
      //return $this->private_key;//如果你的私钥是按照这种方式分割的，屏蔽此项就可以
        $priKey = $this->private_key;
        $formatKey = "-----BEGIN RSA PRIVATE KEY-----\n" .
            wordwrap($priKey, 64, "\n", true) .
            "\n-----END RSA PRIVATE KEY-----";
        return $formatKey;
    }
    //格式化公钥
    private function getFormatPubKey(){
        $pubKey = $this->public_key;
        $res = "-----BEGIN PUBLIC KEY-----\n" .
            wordwrap($pubKey, 64, "\n", true) .
            "\n-----END PUBLIC KEY-----";

        return $res;
    }



    public function checkBackData($checkData){
        $sign = $checkData['sign'];
        $sign_type = $checkData['sign_type'];
        unset($checkData['sign']);
        unset($checkData['sign_type']);

        foreach($checkData as $k=>$v){
            if($k=='passback_params'){
                continue;
            }
            $checkData[$k] = urldecode($v);
        }

        ksort($checkData);

        $stringA = $this->getString($checkData);

        $res = $this->verify($stringA,$sign,$sign_type);

        if(!$res){
            return false;
        }else{
            return true;
        }
    }

}