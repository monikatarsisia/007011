from BeautifulSoup import BeautifulSoup
import urllib2

thisurl = "http://bisniskeuangan.kompas.com/"
handle = urllib2.urlopen(thisurl)
html_doc =  handle.read()
handle.close()

target = open("dataOri.html", 'w')
target.write(html_doc)
target.close()

soup = BeautifulSoup(html_doc)

savelink = open("hyperlink.html", 'w')

for link in soup.findAll('a'):
	anotherlink =link.get('href')
	
	handlelink = urllib2.urlopen(anotherlink)
	html_doclink = handlelink.read()
	targetlink = open("test.html", 'w')
	targetlink.write(html_doclink)
	targetlink.close()
	
	savelink.write(anotherlink)
	savelink.write("\n")
	print(anotherlink)
	handlelink.close()

savelink.close()
