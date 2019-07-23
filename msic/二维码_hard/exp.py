from PIL import Image
MAX = 280
pic = Image.new("RGB",(MAX, MAX))
file = open("flag.txt",'r')
m = file.read().split('\n')
i=0
for y in range (0,MAX):
   for x in range (0,MAX):
       if(m[i] == '(0, 0, 0)'):
           pic.putpixel([x,y],(0, 0, 0))
       else:
           pic.putpixel([x,y],(255,255,255))
       i = i+1
pic.show()
pic.save("flag.png")
