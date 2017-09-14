<?php
$config = array (	
		//应用ID,您的APPID。
		'app_id' => "2017032106327228",

		//商户私钥，您的原始格式RSA私钥
		'merchant_private_key' => "MIIEvAIBADANBgkqhkiG9w0BAQEFAASCBKYwggSiAgEAAoIBAQCr5b+I8keyMiUd1LzJvjjEwglheQuUQrYWszy+ErLf6vsVLg4Cv6DhbztKvQzfpSjLOWKRGHDnsRLRrZ69GoqsY4B9nxlLFQpnAl4TVp4O7Jovjh/NxXcrOuU0uFsxql/aVXsAzddUDCnOgUjJNQa7Jx4OnZwKkPAYCrspxdDaFAohDO1XHrFDQMzXpHY7Rd/68BMtmkC95JPJvln5mHwweph2lnUURgZFJhyzDwWTbzE206DJys7vCFrTOEkaVAIj0t0HJqqLzDgI/19oKPSZive3tGrdkWzUQOkKSWflEEDsTKktTuDXxRwMeXtFFBJRa7Z+9D4DePfnqUem/zLdAgMBAAECggEAVMMJW0H80IWhf8AzB1fhLkRv07yYVRdAKplfTmpyAbAg9ySqi/hqID91ATmPa4hJQUyeqeVfZyANo471Q1IfJzo5VbhqBHfvlTO5p9eCQOGyddijHhhM1uhHtWNitG7KrSKRcKgPkcYdp1JgzbZ0Bz0WuSZGl384pOJFwCdnAOEpDpi+nrvU7IrfyK0IzIjmuIClHu7cLrwgarJL0UMiqFP2/aL4wl/wvZL50cKlLr7dSvsPCrprrDeXlJMucSb/WSW2oDNFn6ykEK1Gi0ZqxnWXNpezD/DQrQzZNq5HY5h5yVHbgYqqfnOxTjch54AaM/uaWM+1WcUSxqBZt6a6gQKBgQDl10+NzqaKj9KiTIKzkHWe19S53CUwO0cn6o/8zJVom8jCvW/rNWCQ/Dur3mVKhRfQy6TJxdCqLASuKNzoS8DtFs5B6xX25Cm7Yaaon84gzIlezwKhmRmQrTz+C6ynC2RTgnRis2iP3JKqJc1aRH6p96gBPsd897f+I1P8va+omQKBgQC/di61UG1ZPSTfEYKl2esxwf2tStW3lWcl6oDrrRl62nLo4Zly2u4NZw1tl8G5534ZE5C8q15RtHGxk1ynRsCUt4ysDAxYoEwL7qne7QJXO16V7c4BnCW43rF7XVxZSDJ91DihEwazRAdB4Ug39F5CMt7AFZpPmCv6h6CsaZuy5QKBgDZHS8VMeS4d2vtzICaxxeU2SUl/QNUMGrjFfy2PTvV+XMIIpMaiO2Th/GGRStB3b/FiNk9kROv7KzvJ8Kl3Ql97VEhi8TP2HBjhbc9CthYu134pWxC4rD3re4zvSt3EJfRGyZ+JiPb4ezZtaPqZVGRlVSq+HbRYd/4vb6UvUq15AoGAEkDKIy8Pvbo+kaWxtu4Xph7AeIzx4xazRsIcmFtgWn4JBnq7jl+g4lY4yYH2TirrsqhS3CnaTB/P1wYdhzUPlx4Ioz5izvA5T8npF/+wgXB/i/un8C9ayU0xznkQHNLtPWHGJFUUBnMt3fIEWJFLizQeWGG23G+9gZz8jHNlDKECgYAQDv/55SKtK4zzywz7kB3FYcmzOfD+QICd11+QRqiY6RiJTvft3JmQOPcLma0GkNvy9p5JVv3O+rhfj7K1Tw4ZlpQvpvx5mEsbgxhbctd1Ts9kZgwwnhPRJgoSn1U7B7+8uY+/QEE0v+knh3Inw54Qhe1KzNrU5bk87lHu8Ow1vA==",
		
		//异步通知地址
		'notify_url' => "http://www.ceshi_alipay.com/notify_url.php",
		
		//同步跳转
		'return_url' => "http://www.ceshi_alipay.com/return_url.php",

		//编码格式
		'charset' => "UTF-8",

		//签名方式
		'sign_type'=>"RSA2",

		//支付宝网关
		'gatewayUrl' => "https://openapi.alipay.com/gateway.do",

		//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
		'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAq+W/iPJHsjIlHdS8yb44xMIJYXkLlEK2FrM8vhKy3+r7FS4OAr+g4W87Sr0M36UoyzlikRhw57ES0a2evRqKrGOAfZ8ZSxUKZwJeE1aeDuyaL44fzcV3KzrlNLhbMapf2lV7AM3XVAwpzoFIyTUGuyceDp2cCpDwGAq7KcXQ2hQKIQztVx6xQ0DM16R2O0Xf+vATLZpAveSTyb5Z+Zh8MHqYdpZ1FEYGRSYcsw8Fk28xNtOgycrO7wha0zhJGlQCI9LdByaqi8w4CP9faCj0mYr3t7Rq3ZFs1EDpCkln5RBA7EypLU7g18UcDHl7RRQSUWu2fvQ+A3j356lHpv8y3QIDAQAB",
		
	
);