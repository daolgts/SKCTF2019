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


