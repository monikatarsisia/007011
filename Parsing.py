from BeautifulSoup import BeautifulSoup
import urllib2

thisurl = "http://bisniskeuangan.kompas.com/"
handle = urllib2.urlopen(thisurl)
html_doc =  handle.read()
#handle.close()

target = open("dataOri.html", 'w')
target.write(html_doc)
target.close()

soup = BeautifulSoup(html_doc)

for link in soup.findAll('a'):
	anotherlink =link.get('href') 
	print(anotherlink)
