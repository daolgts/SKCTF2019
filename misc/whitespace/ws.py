# flag="SKCTF{_F_1_4_G_}"

# for i in flag:
# 	print bin(ord(i))[2:].replace("0"," ").replace("1","\t")

f = open("ws.txt","rb")
flag=[]
for line in f.readlines():
    line=line.replace(' ','0')
    line=line.replace('\t','1')
    try:
        flag.append(chr(int(line,2)))
    except:
        pass
print ''.join((flag))