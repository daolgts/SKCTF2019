#coding=utf-8

def reverse1(str):
    ss = ''
    s = list(str)
    s.reverse()
    ss = "".join(s)
    return ss

def re_hahaha(b, s):
    r = ''
    for x in range(len(b)):
        r += b[(x-s)%len(b)]
    return r

def re_hehehe(b):
    r = ''
    for x in range(len(b)):
        if b[x] == '0':
            r += '1'
        else:
            r += '0'
    return r

encoded = '01000001001101010010110100111101110101011001110100100001101100010101100110010001010110011011000100110001010110010110100100110001100110010101000110001001'

b = reverse1(encoded)
#print b
b = re_hahaha(b,7)
#print b
b = reverse1(b)
#print b
b = re_hehehe(b)
#print b
b = reverse1(b)
#print b
orignal = reverse1(b)
print orignal
#011001010110100101100001000101010011000101101111001000110010001100111011000010110010011101001111010010110010101100110011010101110011101101011111
#len(orignal)=152=19*8

t = ''
for i in range(1,len(orignal)-1,8):
    t += reverse1(orignal[i:i+8])+' '
    i = i + 8
print t
    
codes = t.split(' ')
print codes

flag = ''
for i in range(len(codes)-1):
    flag += chr(int(codes[i], 2))
print flag
print len(flag)
#SKCTF{reverseisfun}

#注：由于规则中有'不满8位补0再翻转顺序'，
#若flag设置为其他字符串时
#可能会出现无法直接得到正确答案的情况，需要手动修复
#例如SKCTF{binaryisfun}的情况跑出的结果是
#SKCTF{bbnhryijfun}

