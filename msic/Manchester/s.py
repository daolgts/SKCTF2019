#coding: utf-8
from PIL import Image

img=Image.open("res.jpg")
img_array=img.load()

code = ''
decode = ''
flag = ''

for i in range(0,368):
	if img_array[i,0][0] < 128:
		code += '1'
	else:
		code += '0'

print (code)

for i in range(0,len(code),2):
	if code[i] == '0' and code[i+1] == '1':
		decode += '0'
	if code[i] == '1' and code[i+1] == '0':
		decode += '1'

print (decode)

for i in range(0,len(decode),8):
	_bin = ''
	for ii in range(1,8):
		_bin += decode[i+ii]
	flag += chr(int(_bin,2))

print (flag)