# 米游社每日签到（原神）
本程序参考自油猴脚本（参考脚本已在作者信息中说明），使用其中算法并使用python、php语言复刻



## 风险说明

使用本程序后，由本程序造成的任何问题均由使用者自负，开发者不承担任何责任。



## 使用说明 

1.由于腾讯云云函数已开始收费，本脚本已去除对腾讯云云函数的支持，如需要腾讯云函数请自行修改程序。  
2.抓取cookie方式可参考[https://www.wunote.cn/article/4713/](https://www.wunote.cn/article/4713/)。  
3.本人原则上不提供任何技术支持，除bug反馈、新功能建议。  
4.本人建设了一个自动签到网站，您在此网站提交cookie后，本站将每日帮你自动签到[https://check-in.llilii.cn/](https://check-in.llilii.cn/)。  
5.欢迎发起Pull Request以帮助我们改进程序。  



## 使用方式

### python脚本

```
# 定时执行以下内容
python index.py "你的米游社COOKIE"
```



### php脚本

```
// 修改php脚本后定时请求此页面
$check_in = new genshin_checkin("你的米游社COOKIE");
var_dump($check_in->main());
```



## 作者信息

作者博客：[某咸鱼的笔记](https://www.wunote.cn/)  
作者邮箱：i#mr-wu.top（#换成@）  
参考脚本1：[网页链接](https://greasyfork.org/zh-CN/scripts/432059-%E7%B1%B3%E6%B8%B8%E7%A4%BE-%E6%B0%B4%E7%BB%8F%E9%AA%8C%E5%8E%9F%E7%A5%9E%E7%AD%BE%E5%88%B0%E5%B7%A5%E5%85%B7)  
参考脚本2：[网页链接](https://greasyfork.org/zh-CN/scripts/448880-%E5%8E%9F%E7%A5%9E%E7%B1%B3%E6%B8%B8%E7%A4%BE%E7%AD%BE%E5%88%B0)  