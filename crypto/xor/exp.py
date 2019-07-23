from base64 import b64decode
file=open("xor.txt","r").read()
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


# rJeekZuQkZjfqpGWiZqNjJaLht+Qmd+snJaakZya356Rm9+rmpyXkZCTkJiG9b6bm42ajIzFysjG366WnpGInpGYnpGY362QnpvT37eKnpGYm56Q37uWjIuNlpyL09+ulpGYm56Q09+sl56Rm5CRmN+vjZCJlpGcmtPfzcnJysbP09+v0a3RvJeWkZ71rLS8q7mEzpvJnsnLm8rGzc/Nyp7LzcbNmp2Zy5mZxpyZxsvOzsuC