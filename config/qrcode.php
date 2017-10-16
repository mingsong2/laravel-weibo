<?php

return [
    'QRCODE' => [
        'level'			=> 'H', //容错等级  L   M   Q   H
        'transparent'	=> false, //是否透明
        'back_color'	=> '#FFFFFF', //背景色   设置了透明该值无效
        'fore_color'	=> '#000000', //前景色   支持前景图片路径
        'block_pixel'	=> 12, //块像素
        'margin_block'	=> 1, //边距占的块数 边距像素=块像素*块数
        'logopath'		=> '', //嵌入LOGO的文件路径
        'size'			=> 0, //二维码图像大小  0=自动
        'text'			=> '', //二维码图片底部文本
        'fontcolor'     => '',
        'incolor'       => '',
        'outcolor'      => '',
        'fontsize'      => '',
        'fontfamily'    => '',
        'background'    => '',
        'qrpad'         => 10,
        'qrcode_eyes'   => 0
    ],
    'QRAPIKEY' => [
        'cliim'				=> 'GX3LZBPVSSX0B2OFKOMTS6J4YKYRGJ7C',
        'bizcliim'			=> '8CFC0F5C156D5AE3541730B52EFE3213',
        'vcardcliim'		=> '97BD357D1F537DD0C031B82C49A17AC6',
        'productcliim'		=> '23D72060E28A51BB8742E46B2199D7D1',
        'vcardadrbookcliim'	=> '7859E6CFCFD1C634411C9DCD585144C4',
        'printcliim'		=> '9212B53701F3CFB5114926C2546E77F5',
        'weixinapi'			=> '07574416B2A2B677F7F158614055724C',
        'newyfgj'			=> '47369FB4A169AAE9B93C1F77667593A4',
        'gl2im'                 =>'23D72060E28A51BB8742E46B2199D7D1'
    ],
    'ALLOWDOMAIN' => ['cli.im','cli.new','cliim.com','cliim.net','biz.cli.im','biz.cli.me','biz.cliim.com','biz.cliim.net','weixin.cli.im','gl2.cliim.net','gl.cli.im','xx.cli.me',''],
    'USER_DOMAIN' => 'http://user.cli.new'
];


