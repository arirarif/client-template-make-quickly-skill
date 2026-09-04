import zipfile, os, struct, zlib
root='niswah-boutique'; out='niswah-boutique.zip'
if os.path.exists(out): os.remove(out)
z=zipfile.ZipFile(out,'w',zipfile.ZIP_DEFLATED)
z.writestr(zipfile.ZipInfo(root+'/'),'')
for d,dirs,files in os.walk(root):
    rel=d.replace(os.sep,'/')
    if '/build' in rel: continue
    if rel!=root: z.writestr(zipfile.ZipInfo(rel+'/'),'')
    for f in files:
        z.write(os.path.join(d,f),rel+'/'+f)
z.close()
print(zipfile.ZipFile(out).namelist())
def chunk(t,d): return struct.pack('>I',len(d))+t+d+struct.pack('>I',zlib.crc32(t+d)&0xffffffff)
png=b'\x89PNG\r\n\x1a\n'+chunk(b'IHDR',struct.pack('>IIBBBBB',1,1,8,2,0,0,0))+chunk(b'IDAT',zlib.compress(b'\x00\xff\x00\x00'))+chunk(b'IEND',b'')
open('04sep2026/disk-test.png','wb').write(png); print('png ok')
