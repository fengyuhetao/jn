USE jn;
SET NAMES utf8;

# tinyint : 0~255
# smallint : 0~ 65535
# mediumint : 0~1千6百多万
# int : 0~40多亿
# char 、varchar 、 text容量？
# char    :0~255个字符
# varchar : 0~65535 字节 看表编码，如果是utf8存2万多汉字 gbk存3万多汉字
# text    : 0~65535 字符

#标尺寸的限制
#一个表中所有字段的大小加起来不能超过65535个字符
 
DROP TABLE IF EXISTS jn_goods;
CREATE TABLE IF NOT EXISTS jn_goods
(
	id mediumint unsigned not null auto_increment,
	goods_name varchar(45) not null comment '商品名称',

	cate_id smallint unsigned not null comment '主分类id',
	brand_id smallint unsigned comment '品牌的id',
	type_id mediumint unsigned not null default '0' comment '商品类型的ID', 

	logo varchar(150) not null default '' comment '商品logo',
	sm_logo varchar(150) not null default '' comment '商品缩略图logo',

	market_price decimal(10,2) not null default '0.00' comment '市场商品价格',
	shop_price decimal(10,2) not null default '0.00' comment '本店商品价格',
	
	jifen int unsigned not null default '0' comment '赠送积分',
	jyz int unsigned not null default '0' comment '赠送经验值',
	jifen_price int unsigned not null default '0' comment '如果要用积分兑换,需要的积分数,0代表不能用积分兑换',
	
	is_promote tinyint unsigned  not null default '0' comment '是否促销',
	promote_price decimal(10, 2) not null default '0.00' comment '促销价',
	promote_start_time int unsigned not null default '0' comment '促销开始时间',
	promote_end_time int unsigned not null default '0' comment '促销结束时间',
	
	is_hot tinyint unsigned not null default '0' comment '是否热卖',
	is_new tinyint unsigned not null default '0' comment '是否新品',
	is_best tinyint unsigned not null default '0' comment '是否精品',

	seo_keyword varchar(150) not null default '' comment 'seo_关键字',
	seo_description varchar(150) not null default '' comment 'seo_描述',

	sort_num tinyint unsigned not null default '100' comment '排序数字',

	goods_desc longtext not null default '' comment '商品描述',
	is_on_sale tinyint unsigned not null default '1' comment '是否上架：1：上架，0：下架',
	is_delete tinyint unsigned not null default '0' comment '是否已经删除，1：已经删除 0：未删除',
	addtime int unsigned not null comment '添加时间',

	primary key (id),
	key brand_id(brand_id),
	key cate_id(cate_id),
	key is_hot(is_hot),
	key is_new(is_new),
	key is_best(is_best),
	key sort_num(sort_num),
	key shop_price(shop_price),
	key promote_start_time(promote_start_time),
	key promote_end_time(promote_end_time),
	key is_on_sale(is_on_sale),
	key is_delete(is_delete),
	key addtime(addtime)
)engine=MyISAM default charset=utf8 comment '商品';
#说明：当要使用LIKE 查询并以%开头时，不能使用普通索引，只以使用全文索引，如果使用了全文索引：
#SELECT * FROM php34_goods WHERE MATCH goods_name AGAINST 'xxxx';
# 但MYSQL自带的全文索引不支持中文，所以不能使用MYSQL自带的全文索引功能，所以如果要优化只能使用第三方的全文索引## 引擎，如：sphinx,lucence等。

DROP TABLE IF EXISTS jn_youhui_price;
CREATE TABLE IF NOT EXISTS jn_youhui_price
(
	goods_id mediumint unsigned not null comment '商品id',
	youhui_number int unsigned not null comment '优惠数量',
	youhui_price decimal(10, 2) not null comment '优惠价格',
	key goods_id(goods_id)
)engine=MyISAM default charset=utf8 comment '扩展分类表';

DROP TABLE IF EXISTS jn_goods_cate;
CREATE TABLE IF NOT EXISTS jn_goods_cate
(
	goods_id mediumint unsigned not null comment '商品id',
	cate_id smallint unsigned not null comment '分类id',
	key goods_id(goods_id),
	key cate_id(cate_id)
)engine=MyISAM default charset=utf8 comment '扩展分类表';

DROP TABLE IF EXISTS jn_brand;
CREATE TABLE IF NOT EXISTS jn_brand
(
	id smallint unsigned not null auto_increment,
	brand_name varchar(45) not null comment '品牌名称',
	site_url varchar(150) not null comment '品牌网站网址',
	logo varchar(150) not null default '' comment '品牌logo',
	primary key(id)
)engine=MyISAM default charset=utf8 comment '品牌表';

DROP TABLE IF EXISTS jn_admin;
CREATE TABLE jn_admin
(
	id tinyint unsigned not null auto_increment,
	username varchar(30) not null comment '账号',
	password char(32) not null comment '密码',
	is_use tinyint unsigned not null default '1' comment '是否启用 1：启用0：禁用',
	primary key (id)
)engine=MyISAM default charset=utf8 comment '管理员';
INSERT INTO jn_admin VALUES(1,'root','bafcbdc80e0ca50e92abe420f506456b',1);

DROP TABLE IF EXISTS jn_category;
CREATE TABLE jn_category
(
	id smallint unsigned not null auto_increment,
	cate_name varchar(30) not null comment '权限名称',
	parent_id smallint unsigned not null default '0' comment '父级ID,0:代表顶级',
	search_attr_id varchar(100) not null default '' comment '筛选ID，多个用逗号隔开',
	primary key (id)
)engine=MyISAM default charset=utf8 comment '商品分类表';

DROP TABLE IF EXISTS jn_privilege;
CREATE TABLE jn_privilege
(
	id smallint unsigned not null auto_increment,
	pri_name varchar(30) not null comment '权限名称',
	module_name varchar(20) not null comment '模块名称',
	controller_name varchar(20) not null comment '控制器名称',
	action_name varchar(20) not null comment '方法名称',
	parent_id smallint unsigned not null default '0' comment '上级权限ID,0:代表顶级权限',
	primary key (id)
)engine=MyISAM default charset=utf8 comment '权限表';

DROP TABLE IF EXISTS jn_role_privilege;
CREATE TABLE jn_role_privilege
(
	pri_id smallint unsigned not null comment '权限的ID',
	role_id smallint unsigned not null comment '角色的ID',
	key pri_id(pri_id),
	key role_id(role_id)
)engine=MyISAM default charset=utf8 comment '角色权限表';

DROP TABLE IF EXISTS jn_role;
CREATE TABLE jn_role
(
	id smallint unsigned not null auto_increment,
	role_name varchar(30) not null comment '角色名称',
	primary key (id)
)engine=MyISAM default charset=utf8 comment '角色表';

DROP TABLE IF EXISTS jn_admin_role;
CREATE TABLE jn_admin_role
(
	admin_id tinyint unsigned not null comment '管理员的ID',
	role_id smallint unsigned not null comment '角色的ID',
	key admin_id(admin_id),
	key role_id(role_id)
)engine=MyISAM default charset=utf8 comment '管理员角色表';

#由以上5张表，取出管理员ID为3的管理员所拥有的所有权限
#流程: 1. 先取出3这个管理员所在的角色ID 
#select role_id from jn_admin_role where admin_id=3
#2.再取出这些角色所拥有的权限的ID 
#select pri_id from jn_role_privilege where role_id in (上一个sql语句的结果)
#3.再根据权限ID取出权限的信息
#select * from jn_privilege where in(上一个sql语句的结果)
#最终
#写法一:select * from jn_privilege where in(select pri_id from jn_role_privilege where role_id in(select role_id from jn_admin_role where admin_id=3));
#写法二:select a.* from jn_privilege a,jn_role_privilege b,jn_admin_role c where c.admin_id=3 and b.role_id=c.role_id and a.id=b.pri_id	
#写法三:select b.* from jn_role_privilege a left join jn_privilege b on a.pri_id=b.id left join jn_admin_role c on a.role_id=c.role_id where c.admin_id=3


#查看某一角色拥有的权限
#select a.*,b.pri_id,GROUP_CONCAT(c.pri_name) from jn_role a left join jn_role_privilege b on a.id=b.role_id left join jn_privilege c on b.pri_id=c.id group by a.id;

DROP TABLE IF EXISTS jn_type;
CREATE TABLE jn_type
(
	id tinyint unsigned not null auto_increment,
	type_name varchar(30) not null comment '类型名称',
	primary key(id)
)engine=MyISAM default charset=utf8 comment '商品类型表';

DROP TABLE IF EXISTS jn_attribute;
CREATE TABLE jn_attribute
(
	id mediumint unsigned not null auto_increment,
	attr_name varchar(30) not null comment '属性名称',
	attr_type tinyint unsigned not null default '0' comment '属性的类型0:唯一 1:可选',
	attr_option_values varchar(150) not null default '' comment '属性的可选值,多个可选值用,隔开',
	type_id tinyint unsigned not null comment '所在类型的id',
	primary key(id),
	key type_id(type_id)
)engine=MyISAM default charset=utf8 comment '属性表';

DROP TABLE IF EXISTS jn_member_level;
CREATE TABLE jn_member_level
(
	id mediumint unsigned not null auto_increment,
	level_name varchar(30) not null comment '级别名称',
	bottom_num int unsigned not null comment '积分下限',
	top_num int unsigned not null comment '积分上限',
	rate tinyint unsigned not null default '100' comment '商品折扣率,按百分比算',
	primary key(id)
)engine=MyISAM default charset=utf8 comment '会员级别';

DROP TABLE IF EXISTS jn_member_price;
CREATE TABLE jn_member_price
(
	goods_id mediumint unsigned not null comment '商品的id',
	level_id mediumint unsigned not null comment '级别id',
	price decimal(10, 2) not null default '0.00' comment '这个级别的价格',
	key goods_id(goods_id),
	key level_id(level_id)
)engine=MyISAM default charset=utf8 comment '会员价格';

DROP TABLE IF EXISTS jn_goods_pics;
CREATE TABLE jn_goods_pics
(
	id mediumint unsigned not null auto_increment,
	goods_id mediumint unsigned not null comment '商品的id',
	pic varchar(150) not null default '' comment '图片的路径',
	sm_pic varchar(150) not null default '' comment '缩略图的路径',
	primary key(id),
	key goods_id(goods_id)
)engine=MyISAM default charset=utf8 comment '商品图片';

DROP TABLE IF EXISTS jn_goods_attr;
CREATE TABLE jn_goods_attr
(
	id int unsigned not null auto_increment,
	goods_id mediumint unsigned not null comment '商品的id',
	attr_id mediumint unsigned not null comment '属性的id',
	attr_value varchar(150) not null default '' comment '属性的值',
	attr_price decimal(10, 2) not null default '0.00' comment '属性的价格',
	primary key(id),
	key attr_id(attr_id),
	key goods_id(goods_id)
)engine=MyISAM default charset=utf8 comment '商品属性表'; 	

DROP TABLE IF EXISTS jn_goods_number;
CREATE TABLE jn_goods_number
(
	#id int unsigned not null auto_increment,
	goods_id mediumint unsigned not null comment '商品的id',
	goods_number int unsigned not null default '0' comment '库存量',
	goods_attr_id varchar(150) not null comment '商品属性ID列表库存量',
	#注释:这里的ID保存的是上面jn_goods_attr表中的id,通过这个ID既可以知道值是什么也可以知道属性是什么，如果有多个ID组合就用,隔开保存一个字符串，并且存时要按ID的升序存，将来前台查询数据库存量的时，也要先把商品属性ID拼成字符串然后查询数据库'
	#primary key(id),
	key goods_id(goods_id)
)engine=InnoDB default charset=utf8 comment '商品库存量'; 	

DROP TABLE IF EXISTS jn_member;
CREATE TABLE jn_member
(
	id mediumint unsigned not null auto_increment comment '会员id',
	email varchar(60) not null comment '会员账号',
	email_code char(32) not null default '' comment '邮箱验证的验证码,当会员验证通过,清空该字段,为空,说明会员已通过验证',
	password char(32) not null comment '密码',
	face varchar(150) not null default '' comment '头像',
	addtime int unsigned not null comment '注册时间',
	jifen int unsigned not null default '0' comment '积分',
	jyz int unsigned not null default '0' comment '经验值',
	primary key(id)
)engine=MyISAM default charset=utf8 comment '会员'; 

DROP TABLE IF EXISTS jn_comment;
CREATE TABLE jn_comment
(
	id mediumint unsigned not null auto_increment comment 'id',
	content varchar(1000) not null comment '评论内容',
	star tinyint unsigned not null default '3' comment '打的分',
	addtime int unsigned not null comment '评论时间',
	member_id mediumint unsigned not null comment '评论者',
	goods_id mediumint unsigned not null comment '商品ID',
	used smallint unsigned not null default '0' comment '有用的数量',
	key goods_id(goods_id),
	primary key(id)
)engine=MyISAM default charset=utf8 comment '商品评论表';

DROP TABLE IF EXISTS jn_reply;
CREATE TABLE jn_reply
(
	id mediumint unsigned not null auto_increment comment 'id',
	content varchar(1000) not null comment '回复内容',
	addtime int unsigned not null comment '回复时间',
	member_id mediumint unsigned not null comment '评论者',
	comment_id mediumint unsigned not null comment '评论ID',
	key comment_id(comment_id),
	primary key(id)
)engine=MyISAM default charset=utf8 comment '商品回复表';

DROP TABLE IF EXISTS jn_clicked_use;
CREATE TABLE jn_clicked_use
(
	member_id mediumint unsigned not null comment '评论者',
	comment_id mediumint unsigned not null comment '评论的ID',
	primary key(member_id, comment_id) #因为这两个字段查询时会一起使用
)engine=MyISAM default charset=utf8 comment '用户点击过有用的评论';

DROP TABLE IF EXISTS jn_impression;
CREATE TABLE jn_impression
(
	id mediumint unsigned not null auto_increment comment 'id',
	imp_name varchar(30) not null comment '印象的标题',
	imp_count smallint unsigned not null default '1' comment '印象出现的次数', 
	goods_id mediumint unsigned not null comment '商品ID',
	key goods_id(goods_id),
	primary key(id)
)engine=MyISAM default charset=utf8 comment '商品印象表';

DROP TABLE IF EXISTS jn_cart;
CREATE TABLE jn_cart
(
	id mediumint unsigned not null auto_increment,
	goods_id mediumint unsigned not null comment '商品id',
	goods_attr_id varchar(30) not null default '' comment '商品的属性ID,多个用,隔开',
	goods_number int unsigned not null comment '购买数量',
	member_id mediumint unsigned not null comment '会员id',
	key member_id(member_id),
	primary key(id)
)engine=MyISAM default charset=utf8 comment '购物车表';

DROP TABLE IF EXISTS jn_order;
CREATE TABLE jn_order
(
	id int unsigned not null auto_increment,
	member_id mediumint unsigned not null comment '会员id',
	addtime int unsigned not null comment '下单时间',
	shr_name varchar(30) not null comment '收货人姓名',
	shr_province varchar(30) not null comment '收货人所在省',
	shr_city varchar(30) not null comment '收货人所在城市',
	shr_area varchar(30) not null comment '收货人所在地区',
	shr_tel varchar(30) not null comment '收货人电话',
	shr_address varchar(30) not null comment '收货人地址',
	total_price decimal(10, 2) not null comment '订单的总价',
	post_method varchar(30) not null comment '发货方式',
	pay_method varchar(30) not null comment '支付方式',
	pay_status tinyint unsigned not null default '0' comment '支付状态，0：未支付 1：已支付',
	post_status tinyint unsigned not null default '0' comment '发货状态，0：未发货 1：已发货 2：已到货',
	order_status tinyint unsigned not null default '0' comment '0：未确认 1：已确认 2：退货中 3.退货完成 4.正常完成',

	key member_id(member_id),
	primary key(id)
)engine=InnoDB default charset=utf8 comment '订单基本表';

DROP TABLE IF EXISTS jn_order_goods;
CREATE TABLE jn_order_goods
(
	order_id int unsigned not null comment '订单id',
	member_id mediumint unsigned not null comment '会员ID',
	goods_id mediumint unsigned not null comment '商品id',
	goods_attr_id varchar(30) not null default '' comment '商品的属性ID,多个用,隔开',
	goods_attr_str varchar(30) not null default '' comment '选择的属性的字符串',
	goods_number int unsigned not null comment '购买数量',
	goods_price decimal(10, 2) not null comment '商品的价格',
	key order_id(order_id),
	key member_id(member_id),
	key goods_id(goods_id)
)engine=InnoDB default charset=utf8 comment '订单商品表';